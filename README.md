`htaccess` - отправляет все запросы в индекс (*index.php*)

`index.php` - начало жизненного цикла приложения
1. Тут станавливается подключение к БД
2. Тут запускается сессия приложения
3. Тут роутится приложение (ну не совсем, но отсюда)

`router.php` = подключает нужный контроллер в зависимости от параметра

`/controllers/*` = содержит контроллеры.
`/models/*` = содержит моедли.

`core` = содержит классы управления приложением и конфиг


##Задание 2
1. составить запрос, который выведет список email'лов встречающихся более чем у одного пользователя

    ```sql SELECT email FROM users GROUP BY email HAVING COUNT(email) > 1;```
2.вывести список логинов пользователей, которые не сделали ни одного заказа
    ```SELECT users.login FROM users
    WHERE users.id NOT IN (SELECT user_id FROM orders)
    GROUP BY users.login```
3.вывести список логинов пользователей которые сделали более двух заказов
   ```SELECT users.login FROM orders
   LEFT JOIN users ON users.id = orders.user_id
   GROUP BY users.login HAVING count(orders.user_id)>2;
   ```