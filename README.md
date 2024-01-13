#  Project Name

Fetch Articles Through Command

## Project Description

This Laravel project implements a custom Artisan command, `fetch_articles`, designed to retrieve and display information from the Dev.to API in a tabular format. The command provides flexibility through the following options:

### Command Name

- **`fetch_articles`**: The primary command responsible for fetching articles from the Dev.to API.

### Command Options

1. **`--limit`**: Determines the number of articles to fetch. Defaults to 5 if not specified.
2. **`--has_comments_only`**: Filters articles to include only those with comments_count greater than 0.

### Data Source

The project utilizes the Dev.to API as the data source. Documentation for the API can be found [here](https://developers.forem.com/api/v1#tag/articles/operation/getArticles).

### Displayed Fields

The `fetch_articles` command displays information in a tabular format, including the following fields from the API response:

- `title`
- `readable_publish_date`
- `comments_count`
- `user.username`

### Implementation

The command is designed to fetch articles in real-time, providing users with the latest information available from the Dev.to platform.



## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- [Docker](https://www.docker.com/)

## Getting Started

Follow these steps to get the project up and running:

1. Clone the repository:

    ```bash
    git clone https://github.com/Ikeoluwa-Oloruntoba/payetask.git
    ```

2. Navigate to the project directory:

    ```bash
    cd yourproject
    ```

3. Setup the project using Docker:

    ```bash
    make setup
    ```

    This command will build the Docker containers, install dependencies, and configure the environment.


4. Access the application:

    Open your web browser and go to [http://localhost:8000](http://localhost:8000) to view the application.



## Contributing

If you'd like to contribute to this project, please follow the [Contributing Guidelines](CONTRIBUTING.md).

## License

This project is licensed under the [MIT License](LICENSE).
