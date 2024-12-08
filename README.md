# Домашние проекты по PHP (Продвинутый уровень)
## Задания 
### Задание 1 (ООП)
1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
2. Описать свойства класса из п.1 (состояние).
3. Описать поведение класса из п.1 (методы).
4. Придумать наследников класса из п.1. Чем они будут отличаться?

### Задание 2 (SQL в проекте)
1. Сделать таблицы DB для проекта
2. Сделать модели для этих таблиц
3. Добавить namespace для каждого класса и доработать автозагрузчик

### Задание 3 (CRUD и PDO)
1. Создать у моделей свойства с полями для sql запроса.
2. Реализовать метод filling в который передаем массив свойств (name = value) а он заполняет свойства.
3. Реализовать метод insert в модели - который создает sql запрос.
4. Реализовать методы update / delete  (так же реализовать save (update+insert))
5. Реализовать методы так чтобы они работали только с заполненными свойствами (в insert/delete проверку вынести в отдельный метод) 
6. *Доработать метод find / findAll так чтобы они возвращали не массив массивов а массив обьектов (через функцию PDO)

### Задание 4 (MVC и CRUD)
1. CRUD операции:
- Завершить реализацию функций update и save, если ещё не сделано.
- Сделать методы update и insert приватными.
2. Модель MVC:
- Реализовать вывод каталогов товаров
- Отобразить список товаров и детальное описание отдельного товара
- Добавить кнопку "Назад"

### Задание 5 (Twig и Composer)
1. Настроить Composer.
2. Установить Twig через Composer.
3. Настроить автолоадер через Composer.
4. Настроить загрузку файлов в приложение с помощью стандарта PSR-4.
5. Настроить метод render, чтобы он работал через Twig

### Задание 6 (Twig, Clean URLs, SOLID)
1. Доработка Twig:
   - Улучшена наследуемость шаблонов
   - Добавлен метод render в класс Model
2. Реализация модуля (Request) обработки запросов:
   - Добавлены методы для GET, POST и др.
   - Настроена корректная маршрутизация URL
     (через .htaccess для Apache или конфиг nginx)
3. Создание страницы ошибки 404:
   - Реализована обработка неправильных URL
4. Разработка функционала корзины:
   - Реализованы все необходимые функции
5. Рефакторинг моделей согласно принципам SOLID:
   - Разделено создание модели и сохранение данных
   - Реализован паттерн Репозиторий:
     * Сущности: хранят базовую информацию (id, name, info)
       и методы получения свойств
     * Репозитории: обрабатывают операции с данными
       (поиск, удаление и т.д.)
### Задание 7 (контейнер внедрения зависимостей)
1. Рефакторинг сущностей, репозиториев и общего кода.
2. Улучшить рендеринг представлений.
3. Использовать контейнер внедрения зависимостей.
4. Реализовать добавление и отображение товаров в корзине, используя сессии для хранения.
5. Реализовать создание заказов и их отображение.
6. Реализовать авторизацию пользователей.
7. Создать админский раздел для просмотра заказов (доступен только администраторам, в разделе заказы пользователей).
8. Внедрить AJAX с jQuery.
### Задание 8
