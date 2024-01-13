<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchArticleService;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch_articles {--limit=5 : Specify Number of Articles} {--has_comments_only : Articles with Comments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Fetches Articles From https://developers.forem.com/api/v1#tag/articles/operation/getArticles';

    /**
     * Execute the console command.
     */
    public function handle(FetchArticleService $fetchArticleService)
    {
        $limit = $this->option('limit');
        $hasCommentsOnly = $this->option('has_comments_only');

        // Fetch articles using the service
        $articles = $fetchArticleService->fetchArticles($limit, $hasCommentsOnly);

        return $fetchArticleService->displayTable($articles);

    }
}
