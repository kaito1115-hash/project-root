# ベースイメージとして公式のPHP 8.3イメージを使用
FROM php:8.3-apache

# 必要なPHP拡張モジュールをインストール
RUN docker-php-ext-install pdo_mysql



