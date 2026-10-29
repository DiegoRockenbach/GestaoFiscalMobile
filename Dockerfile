FROM php:8.5-apache

# Configuração de produção: não mostra erros para o visitante.
# Os erros continuam indo para o log do container (docker logs).
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# - expose_php: não divulga a versão do PHP no cabeçalho X-Powered-By.
# - session.upload_progress.enabled: mitigação recomendada pelo php.net (aviso de 23/10/2026,
#   CVE-2026-109619 / CVE-2026-115560) até a próxima versão de correção. O app não usa upload.
RUN printf 'expose_php = Off\nsession.upload_progress.enabled = 0\n' > "$PHP_INI_DIR/conf.d/zz-seguranca.ini"

COPY ./ /var/www/html
