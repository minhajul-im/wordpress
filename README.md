# WordPress with Docker

Local WordPress development environment using Docker Compose.

## Services

| Service    | Port  | Description              |
|------------|-------|--------------------------|
| WordPress  | 8080  | CMS at http://localhost:8080 |
| phpMyAdmin | 8081  | DB UI at http://localhost:8081 |
| MariaDB    | —     | Database (internal only) |

## Quick Start

```bash
# 1. Clone the repo
git clone <your-repo-url>
cd <repo-folder>

# 2. Create your environment file
cp .env.example .env
# Edit .env and set your passwords

# 3. Start
docker compose up -d

# 4. Open WordPress and complete the install
open http://localhost:8080
```

## Useful Commands

```bash
docker compose up -d        # Start in background
docker compose down         # Stop all services
docker compose logs -f      # View logs
docker compose exec database sh  # Open DB shell
```

## Notes

- WordPress files are stored in `wordpress-files/` (gitignored)
- Database data persists in a Docker named volume (`db_data`)
- Never commit `.env` — it contains your passwords
