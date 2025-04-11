# .devcontainer/Dockerfile
FROM php:8.4-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    sudo

# Instalar extensões PHP
RUN docker-php-ext-install \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário não-root
RUN useradd -m -s /bin/bash -u 1000 vscode && \
    echo "vscode ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/vscode && \
    chmod 0440 /etc/sudoers.d/vscode

# Configurações do PHP
COPY ./php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Definir diretório de trabalho
WORKDIR /workspace

# Mudar para o usuário não-root
USER vscode