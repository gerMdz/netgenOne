### Cap 1
Inicio común
composer...
yarn...
composer require netgen/layouts-standard

* Para evitar borrar las tablas de nglayouts al hacer migraciones.
`schema_filter: '~^(?!nglayouts_)~'`

symfony console doctrine:migrations:migrate --configuration=vendor/netgen/layouts-core/migrations/doctrine.yml

### Next 
[Cap 4](https://symfonycasts.com/es/screencast/netgen-layouts/shared-layouts#play)

