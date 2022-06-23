<?php

class block_student_data extends block_base {

    public function instance_allow_multiple() {
        return true;
    }

    public function init() {
        $this->title = get_string('student_data', 'block_student_data');
    }
    public function get_content() {

        global $DB, $USER, $OUTPUT, $CFG;

        if ($this->content !== null) {
          return $this->content;
        }

        $plugin = "block_performance";
        $name1 = 'login';
        $name2 = 'password';
        $name3 = 'link';

        $usrlogin = get_config($plugin, $name1);
        $usrpwd = get_config($plugin, $name2);
        $server = get_config($plugin, $name3);

//        $the_server = get_config($plugin, $name3);
//        $userlogin = 'lk';
//        $userpwd = 'fO0ju9tu';
//        var_dump($usrpwd);

        $firstname = $USER->firstname;
        $lastname = $USER->lastname;

//http://10.1.1.24/univer_test2/odata/standard.odata/
//Catalog_ФизическиеЛица
//?$format=json
//&$filter=
//Фамилия eq 'Степанова' and Имя eq 'Маргарита'
//&$select=
//Ref_Key,Фамилия,Имя

//        $server = 'http://10.1.1.24/univer_test2/odata/standard.odata/';

        $catalog_fio = 'Catalog_ФизическиеЛица';
        $catalog_fio_encoded = rawurlencode($catalog_fio);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_name = "Фамилия eq '$lastname' and Имя eq '$firstname'";
        $param_filter_name_encoded = rawurlencode($param_filter_name);

        $select = '&$select=';
        $param_select_name = 'Ref_Key,Фамилия,Имя';
        $param_select_name_encoded = rawurlencode($param_select_name);

        $url_name = $server . $catalog_fio_encoded . $param . $filter . $param_filter_name_encoded . $select . $param_select_name_encoded;

        $ch_name = curl_init($url_name);

        $connect = curl_setopt($ch_name, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch_name, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_name, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_name, CURLOPT_HEADER, false);
        curl_setopt($ch_name, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch_name, CURLOPT_TIMEOUT, 3600);

        $html_name = curl_exec($ch_name);
        $j_name = json_decode($html_name, true);

        $Ref_Key_name = $j_name["value"][0]["Ref_Key"];
        $Surname = $j_name["value"][0]["Фамилия"];
        $Name = $j_name["value"][0]["Имя"];
//=======================================Общие данные=============================================
//http://10.1.1.24/univer_test2/odata/standard.odata/
//Document_Приказы_ОбщиеДанные
//?$format=json
//&$filter=
//ФизическоеЛицо_Key eq guid'de061fcd-64b1-11ec-811d-ac1f6b1c60fc'
//&$select=
//Ref_Key,ЗачетнаяКнига_Key,ДатаНачала,Факультет_Key,ФормаОбучения_Key,Специальность_Key,Профиль_Key,Курс_Key,Группа_Key

        $document_prikaz = 'Document_Приказы_ОбщиеДанные';
        $document_prikaz_encoded = rawurlencode($document_prikaz);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_fio = "ФизическоеЛицо_Key eq guid'$Ref_Key_name'";
        $param_filter_fio_encoded = rawurlencode($param_filter_fio);

        $select = '&$select=';
        $param_select = 'Ref_Key,ФизическоеЛицо_Key,ЗачетнаяКнига_Key,ДатаНачала,Факультет_Key,ФормаОбучения_Key,Специальность_Key,Профиль_Key,Курс_Key,Группа_Key';
        $param_select_encoded = rawurlencode($param_select);

        $url = $server . $document_prikaz_encoded . $param . $filter . $param_filter_fio_encoded . $select . $param_select_encoded;

        $ch1 = curl_init($url);

        $connect = curl_setopt($ch1, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_HEADER, false);
        curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1, CURLOPT_TIMEOUT, 3600);

        $html1 = curl_exec($ch1);
        $j = json_decode($html1, true);

        $Ref_Key_doc = $j["value"][0]["Ref_Key"];
        $Human_Key = $j["value"][0]["ФизическоеЛицо_Key"];
        $Book_Key = $j["value"][0]["ЗачетнаяКнига_Key"];
        $Date_Begin = $j["value"][0]["ДатаНачала"];
        $Faculty_Key = $j["value"][0]["Факультет_Key"];
        $Study_form_Key = $j["value"][0]["ФормаОбучения_Key"];
        $Speciality_Key = $j["value"][0]["Специальность_Key"];
        $Profile_Key = $j["value"][0]["Профиль_Key"];
        $Course_Key = $j["value"][0]["Курс_Key"];
        $Group_Key = $j["value"][0]["Группа_Key"];

//=======================================GROUP=============================================
//http://10.1.1.24/univer_test2/odata/standard.odata/
//Catalog_УчебныеГруппы
//?$format=json
//&$filter=
//Ref_Key eq guid'de061fcd-64b1-11ec-811d-ac1f6b1c60fc'
//&$select=
//Ref_Key,Description
        $document_group = 'Catalog_УчебныеГруппы';
        $document_group_encoded = rawurlencode($document_prikaz);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_group = "Ref_Key eq guid'$Group_Key'";
        $param_filter_group_encoded = rawurlencode($param_filter_group);

        $select = '&$select=';
        $param_select_group = 'Ref_Key,Description';
        $param_select_group_encoded = rawurlencode($param_select_group);

        $url_group = $server . $document_group_encoded . $param . $filter . $param_filter_group_encoded . $select . $param_select_group_encoded;

        $ch1_group = curl_init($url_group);

        $connect = curl_setopt($ch1_group, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_group, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_group, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_group, CURLOPT_HEADER, false);
        curl_setopt($ch1_group, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_group, CURLOPT_TIMEOUT, 3600);

        $html1_group = curl_exec($ch1_group);
        $j_group = json_decode($html1_group, true);

        $Ref_Key_group = $j_group["value"][0]["Ref_Key"];
        $Description_group = $j_group["value"][0]["Description"];
//      var_dump($Description_group);

//===========================================Зачетная книга==========================================
//Catalog_ЗачетныеКниги?$format=json&$filter=Owner_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description

        $catalog_book = 'Catalog_ЗачетныеКниги';
        $catalog_book_encoded = rawurlencode($catalog_book);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_book = "Owner_Key eq guid'$Human_Key'";
        $param_filter_book_encoded = rawurlencode($param_filter_book);

        $select = '&$select=';
        $param_select_book = 'Ref_Key,Description';
        $param_select_book_encoded = rawurlencode($param_select_book);

        $url_book = $server . $catalog_book_encoded . $param . $filter . $param_filter_book_encoded . $select . $param_select_book_encoded;
        $ch1_book = curl_init($url_book);

        $connect = curl_setopt($ch1_book, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_book, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_book, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_book, CURLOPT_HEADER, false);
        curl_setopt($ch1_book, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_book, CURLOPT_TIMEOUT, 3600);

        $html1_book = curl_exec($ch1_book);
        $j_book = json_decode($html1_book, true);

        $Ref_Key_book = $j_book["value"][0]["Ref_Key"];
        $Description_book = $j_book["value"][0]["Description"];
//var_dump($Description_book);

//===========================================Факультет==========================================
//Catalog_СтруктураУниверситета?$format=json&$filter=Ref_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description

        $catalog_faculty = 'Catalog_СтруктураУниверситета';
        $catalog_faculty_encoded = rawurlencode($catalog_faculty);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_faculty = "Ref_Key eq guid'$Faculty_Key'";
        $param_filter_faculty_encoded = rawurlencode($param_filter_faculty);

        $select = '&$select=';
        $param_select_faculty = 'Ref_Key,Description';
        $param_select_faculty_encoded = rawurlencode($param_select_faculty);

        $url_faculty = $server . $catalog_faculty_encoded . $param . $filter . $param_filter_faculty_encoded . $select . $param_select_faculty_encoded;
        $ch1_faculty = curl_init($url_faculty);

        $connect = curl_setopt($ch1_faculty, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_faculty, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_faculty, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_faculty, CURLOPT_HEADER, false);
        curl_setopt($ch1_faculty, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_faculty, CURLOPT_TIMEOUT, 3600);

        $html1_faculty = curl_exec($ch1_faculty);
        $j_faculty = json_decode($html1_faculty, true);

        $Ref_key_faculty = $j_faculty["value"][0]["Ref_Key"];
        $Faculty_name = $j_faculty["value"][0]["Description"];
//var_dump($Faculty_name);

//===========================================Форма обучения==========================================
//Catalog_ФормаОбучения?$format=json&$filter=Ref_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description

        $catalog_studyForm = 'Catalog_ФормаОбучения';
        $catalog_studyForm_encoded = rawurlencode($catalog_studyForm);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_studyForm = "Ref_Key eq guid'$Study_form_Key'";
        $param_filter_studyForm_encoded = rawurlencode($param_filter_studyForm);

        $select = '&$select=';
        $param_select_studyForm = 'Ref_Key,Description';
        $param_select_studyForm_encoded = rawurlencode($param_select_studyForm);

        $url_studyForm = $server . $catalog_studyForm_encoded . $param . $filter . $param_filter_studyForm_encoded . $select . $param_select_studyForm_encoded;
        $ch1_studyForm = curl_init($url_studyForm);

        $connect = curl_setopt($ch1_studyForm, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_studyForm, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_studyForm, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_studyForm, CURLOPT_HEADER, false);
        curl_setopt($ch1_studyForm, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_studyForm, CURLOPT_TIMEOUT, 3600);

        $html1_studyForm = curl_exec($ch1_studyForm);
        $j_studyForm = json_decode($html1_studyForm, true);

        $Ref_Key_studyForm = $j_studyForm["value"][0]["Ref_Key"];
        $Study_form = $j_studyForm["value"][0]["Description"];
//var_dump($Study_form);

//===========================================Специальность==========================================
//Catalog_Специальности?$format=json&$filter=Ref_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description,КодСпециальности
        $catalog_speciality = 'Catalog_Специальности';
        $catalog_speciality_encoded = rawurlencode($catalog_speciality);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_speciality = "Ref_Key eq guid'$Speciality_Key'";
        $param_filter_speciality_encoded = rawurlencode($param_filter_speciality);

        $select = '&$select=';
        $param_select_speciality = 'Ref_Key,Description,КодСпециальности';
        $param_select_speciality_encoded = rawurlencode($param_select_speciality);

        $url_speciality = $server . $catalog_speciality_encoded . $param . $filter . $param_filter_speciality_encoded . $select . $param_select_speciality_encoded;
        $ch1_speciality = curl_init($url_speciality);

        $connect = curl_setopt($ch1_speciality, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_speciality, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_speciality, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_speciality, CURLOPT_HEADER, false);
        curl_setopt($ch1_speciality, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_speciality, CURLOPT_TIMEOUT, 3600);

        $html1_speciality = curl_exec($ch1_speciality);
        $j_speciality = json_decode($html1_speciality, true);

        $Ref_Key_Speciality = $j_speciality["value"][0]["Ref_Key"];
        $Speciality = $j_speciality["value"][0]["Description"];
        $UID_speciality = $j_speciality["value"][0]["КодСпециальности"];
//var_dump($Speciality);

//===========================================Профиль (специализация) ==========================================
//Catalog_Специализации?$format=json&$filter=Ref_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description

        $catalog_profile = 'Catalog_Специализации';
        $catalog_profile_encoded = rawurlencode($catalog_profile);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_profile = "Ref_Key eq guid'$Profile_Key'";
        $param_filter_profile_encoded = rawurlencode($param_filter_profile);

        $select = '&$select=';
        $param_select_profile = 'Ref_Key,Description';
        $param_select_profile_encoded = rawurlencode($param_select_profile);

        $url_profile = $server . $catalog_profile_encoded . $param . $filter . $param_filter_profile_encoded . $select . $param_select_profile_encoded;
        $ch1_profile = curl_init($url_profile);

        $connect = curl_setopt($ch1_profile, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_profile, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_profile, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_profile, CURLOPT_HEADER, false);
        curl_setopt($ch1_profile, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_profile, CURLOPT_TIMEOUT, 3600);

        $html1_profile = curl_exec($ch1_profile);
        $j_profile = json_decode($html1_profile, true);

        $Ref_Key_Profile = $j_profile["value"][0]["Ref_Key"];
        $Profile = $j_profile["value"][0]["Description"];
//var_dump($Profile);

//===========================================Курс==========================================
//Catalog_Курсы?$format=json&$filter=Ref_Key eq guid'38e4fd7f-d826-11eb-8101-ac1f6b1c60fc'&$select=Ref_Key,Description
        $catalog_course = 'Catalog_Курсы';
        $catalog_course_encoded = rawurlencode($catalog_course);

        $param = '?$format=json';
        $filter = '&$filter=';

        $param_filter_course = "Ref_Key eq guid'$Course_Key'";
        $param_filter_course_encoded = rawurlencode($param_filter_course);

        $select = '&$select=';
        $param_select_course = 'Ref_Key,Description';
        $param_select_course_encoded = rawurlencode($param_select_course);

        $url_course = $server . $catalog_course_encoded . $param . $filter . $param_filter_course_encoded . $select . $param_select_course_encoded;
        $ch1_course = curl_init($url_course);

        $connect = curl_setopt($ch1_course, CURLOPT_USERPWD, "$usrlogin:$usrpwd");
        curl_setopt($ch1_course, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1_course, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1_course, CURLOPT_HEADER, false);
        curl_setopt($ch1_course, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch1_course, CURLOPT_TIMEOUT, 3600);

        $html1_course = curl_exec($ch1_course);
        $j_course = json_decode($html1_course, true);

        $Ref_Key_Course = $j_course["value"][0]["Ref_Key"];
        $Course = $j_course["value"][0]["Description"];
//var_dump($Course)

//==============================================Вывод информации===================================================

        $this->content         =  new stdClass;
        $this->content->text   = "<strong>" . "Код направления подготовки: " . "</strong>" . "<br>" . $UID_speciality . "<br>". "<br>"
            . "<strong>" . "Направление подготовки: " . "</strong>" . "<br>" . $Speciality . "<br>" . "<br>"
            . "<strong>" . "Направленность: " . "</strong>" . "<br>" . $Profile . "<br>" . "<br>"
            . "<strong>" . "Форма обучения: " . "</strong>" . "<br>" . $Study_form . "<br>" . "<br>"
            . "<strong>" . "Факультет: " . "</strong>" . "<br>" . $Faculty_name . "<br>" . "<br>"
            . "<strong>" . "Курс: " . "</strong>" . "<br>" . $Course . "<br>" . "<br>"
            . "<strong>" . "Группа: " . "</strong>" . "<br>" . $Description_group . "<br>" . "<br>"
            . "<strong>" . "Номер зачетной книжки: " . "</strong>" . "<br>" . $Description_book . "<br>" . "<br>"
            . "<strong>" . "Год поступления: " . "</strong>" . "<br>" . substr($Date_Begin, 0, 4) . "<br>" . "<br>";

        return $this->content;

    }

}