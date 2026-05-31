# blog_app WriteX Blog

Aplikacion blog i ndërtuar me PHP dhe MySQL, me panel administrimi dhe chatbot të integruar me AI.

## Teknologjitë

- **Backend:** PHP (procedural)
- **Databaza:** MySQL / MySQLi
- **Frontend:** HTML, CSS, JavaScript (Vanilla)
- **AI Chatbot:** Groq API (Llama 3.3 70B)
- **Server:** Apache / XAMPP (lokal)

## Funksionalitetet

### Pjesa publike
- Faqe kryesore me postin e veçuar (featured)
- Listim i postimeve me paginim
- Filtrimi i postimeve sipas kategorisë
- Kërkim i postimeve (search)
- Faqe e plotë e çdo postimi
- Likes dhe komente (vetëm për përdorues të loguar)
- Share i postimeve në platforma sociale
- Chatbot i integruar me AI (kërkon llogari)

### Panel i administrimit (`/admin`)
- Dashboard me postimet e autorit
- Shtim, editim dhe fshirje postimesh
- Menaxhim kategorish
- Menaxhim përdoruesish (admin)
- Ngarkimi i imazheve për postime dhe avatar

### Autentifikim
- Regjistrim me avatar
- Hyrje me username ose email
- Logout i sigurt
- Roli i dyfishtë: `author` dhe `admin`

## Instalimi lokal

### Kërkesat
- XAMPP (ose server tjetër me PHP 8+ dhe MySQL)
- PHP 8.0+

### Hapat

1. Klono repo-n brenda folderit `htdocs`:
```bash
git clone https://github.com/danielahmetaj1/blog_app.git
```

2. Hap **phpMyAdmin** dhe krijo një databazë të re me emrin `blog_app`.

3. Importo skemanin SQL (nëse ekziston), ose krijo tabelat manualisht sipas strukturës:

```sql
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'author') DEFAULT 'author',
    avatar VARCHAR(255)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    body TEXT,
    thumbnail VARCHAR(255),
    category_id INT,
    user_id INT,
    is_featured TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT,
    body TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT
);

CREATE TABLE shares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    platform VARCHAR(50),
    ip_address VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Konfiguro lidhjen me databazën duke edituar `config/constants.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // përdoruesi yt i MySQL
define('DB_PASS', '');           // password-i yt
define('DB_NAME', 'blog_app');
define('ROOT_URL', 'http://localhost/blog_app/');
```

5. Nëse dëshiron të aktivizosh chatbot-in, hap `Chatbot.php` dhe vendos API key-n tënd nga [console.groq.com](https://console.groq.com) (falas):

```php
$api_key = 'gsk_...'; // API key-ja jote
```

6. Hap shfletuesin dhe shko te `http://localhost/blog_app/`

## Struktura e projektit

```
blog_app/
├── admin/               # Panel i administrimit
│   ├── config/          # Konfigurim i databazës (admin)
│   ├── partials/        # Header i panelit
│   └── *.php            # Faqet e menaxhimit
├── config/
│   ├── constants.php    # Konfigurimet kryesore (DB, URL)
│   └── database.php     # Lidhja me databazën
├── css/                 # Stizimet CSS
├── images/              # Imazhet e ngarkuara
├── js/                  # Skriptet JavaScript
├── partials/            # Header dhe footer të përbashkëta
├── index.php            # Faqja kryesore
├── blog.php             # Listimi i postimeve
├── post.php             # Postimi i plotë
├── signin.php           # Hyrja
├── signup.php           # Regjistrimi
├── search.php           # Kërkimi
├── Chatbot.php          # Endpoint-i i chatbot-it
└── README.md
```

## Shënime

Ky projekt është zhvilluar si projekt akademik/personal dhe funksionon vetëm në mjedis lokal. Nuk është i destinuar për deployment në server prodhimi pa rregullime shtesë të sigurisë.

## Autori
**Daniel Ahmetaj** — [@danielahmetaj1](https://github.com/danielahmetaj1)
**Denis Daja**
**Besnik Hoxha**
