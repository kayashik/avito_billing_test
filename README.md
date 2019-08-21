Это тестовое задание для avito billing (https://github.com/valinurovam/avi-pro-test)
POSTMEN file - AVITO BILLING.postman_collection

Документация к API:
 
	POST {domein}/api/generate
	 	input:
	 		type: string|null (int - число, str - строка (по-умолчанию), guid, int_str - цифробуквенное, set - из заданных значений),
	 		length: int|null (16 - по-умолчанию),
	 		values: array - непустой массив значений для типа set
	 	output:
			id: int
			message: string

	GET {domein}/api/retrieve/{id}
	 	output:
			id: int
			result: string
			type: string
			message: string

Инструкция к docker:
	1. docker-compose up -d
	2. docker-compose exec php-fpm php artisan migrate
	3. go to localhost:8000


	Контроллер - app/Http/Controllers/Api/GenerateController 
	Тесты - tests/Unit/GenerationTest
	Routes - routes/api
