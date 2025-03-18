# Escolha uma imagem base adequada
FROM php:7.4-cli

# Defina o diretório de trabalho
WORKDIR /app

# Copie os arquivos do repositório para o container
COPY . .

# Instale dependências (se necessário)
RUN apt-get update && apt-get install -y unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install

# Comando padrão (ajuste conforme sua necessidade)
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
