# modleplugin
Diploma plugin
Плагин для СУО Мурманского арктического государственного университета, автоматизирующего заполнение профиля студентов корректными данными для Moodle.
Данный плагин является автоматизацией процесса получения, обновления и корректного отображения сведений о студентах и работает следующим образом: 
Блок Moodle с помощью HTTP-запросов по протоколу OData авторизуется в ИС 1С и посредством точечных Odata запросов выдергивает информацию по имени и фамилии пользователя, хранящегося в БД Moodle.
Данные отображаются в блоке в личном кабинете при авторизации в СУО.
