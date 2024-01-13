<?php

namespace App\Services;

use App\Helpers\GuzzleHttpHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class FetchArticleService{

    protected $httpClient;
    protected $consoleOutput;
    private $headers = [
        'Content-Type' => 'application/json',
    ];



    public function __construct(GuzzleHttpHelper $httpClient, ConsoleOutput $consoleOutput)
    {
        $this->httpClient = $httpClient;
        $this->consoleOutput = $consoleOutput;

    }

    //Trigger From Through Method

    public function fetchArticles($limit = 5, $hasCommentsOnly = false)
    {
        $url = env('DEV_TO_ARTICLES_BASE_URL') . '/articles';

        // Fetch articles from the API using the GuzzleHttpHelper
        $articles = $this->fetchArticlesFromApi($url, $limit);
       
        // Process and filter articles
        return $this->processArticles($articles, $hasCommentsOnly);
    }


    //Get From Api Method

    protected function fetchArticlesFromApi($url, $limit)
    {
        return $this->httpClient->get($url, [
            'per_page' => $limit,
        ], $this->headers);
    }

    protected function processArticles($articles, $hasCommentsOnly)
    {
        if ($articles['status'] == 'success') {
            // Filter articles if hasCommentsOnly is true
            if ($hasCommentsOnly) {
                $articles['data'] = array_filter($articles['data'], function ($article) {
                    return $article->comments_count > 5;
                });
            }

            // Format the response in a tabular form
            return array_map(function ($article) {
                return [
                    'title' => $article->title,
                    'readable_publish_date' => $article->readable_publish_date,
                    'comments_count' => $article->comments_count,
                    'username' => $article->user->username,
                ];
            }, $articles['data']);
            
        } else {
            // Handle errors here based on your requirements
            return $articles['message'];
        }
    }


    //Table Format Display


    public function displayTable($data)
    {
        if (is_array($data) && !empty($data)) {
            $headers = ['Title', 'Readable Publish Date', 'Comments Count', 'Username'];

            $rows = [];

            foreach ($data as $article) {
                $rows[] = [
                    $article['title'],
                    $article['readable_publish_date'],
                    $article['comments_count'],
                    $article['username'],
                ];
            }

            $table = new Table($this->consoleOutput);
            $table->setHeaders($headers)->setRows($rows);
            $table->render();
        } else {
            $this->consoleOutput->writeln('<error>No data to display.</error>');
        }
    }




}
 