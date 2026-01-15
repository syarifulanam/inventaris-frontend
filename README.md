# Inventaris Frontend

Frontend aplikasi inventaris berbasis Laravel yang terhubung ke REST API backend.

## Fitur

-   **Dashboard** - Halaman utama
-   **Products** - CRUD produk & fitur sell
-   **Users** - CRUD user & fitur change role

## Requirements

-   PHP 8.1+
-   Composer
-   Node.js & NPM

## Instalasi

1. **Clone repository**

    ```bash
    git clone git@github.com:syarifulanam/inventaris-frontend.git
    cd inventaris-frontend
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi API Backend**

    Edit file `.env` dan tambahkan URL API backend:

    ```
    API_BACKEND_URL=http://127.0.0.1:8000
    ```

5. **Build assets**

    ```bash
    npm run build
    ```

6. **Jalankan server**

    ```bash
    php artisan serve
    ```

    Akses di browser: `http://127.0.0.1:8001`

## Development

Untuk development dengan hot reload:

```bash
npm run dev
```

## Struktur API

Frontend ini mengkonsumsi API dari backend dengan endpoint:

| Method | Endpoint                      | Deskripsi      |
| ------ | ----------------------------- | -------------- |
| GET    | `/api/products`               | List produk    |
| POST   | `/api/products`               | Tambah produk  |
| POST   | `/api/products/{id}/sell`     | Jual produk    |
| GET    | `/api/users`                  | List user      |
| POST   | `/api/users`                  | Tambah user    |
| GET    | `/api/users/{id}`             | Detail user    |
| PUT    | `/api/users/{id}/change-role` | Ubah role user |
| GET    | `/api/roles`                  | List roles     |

## License

MIT
