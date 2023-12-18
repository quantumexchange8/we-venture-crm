<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'ต้องยอมรับ :attribute',
    'accepted_if' => 'ต้องยอมรับ :attribute เมื่อ :other เป็น :value',
    'active_url' => ':attribute ไม่ใช่ URL ที่ถูกต้อง',
    'after' => ':attribute ต้องเป็นวันที่หลัง :date',
    'after_or_equal' => ':attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date',
    'alpha' => ':attribute ต้องประกอบด้วยตัวอักษรเท่านั้น',
    'alpha_dash' => ':attribute ต้องประกอบด้วยตัวอักษร ตัวเลข ขีดล่างและขีดกลางเท่านั้น',
    'alpha_num' => ':attribute ต้องประกอบด้วยตัวอักษรและตัวเลขเท่านั้น',
    'array' => ':attribute ต้องเป็นแอเรย์',
    'before' => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal' => ':attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date',
    'between' => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min และ :max',
        'file' => ':attribute ต้องอยู่ระหว่าง :min และ :max กิโลไบต์',
        'string' => ':attribute ต้องอยู่ระหว่าง :min และ :max ตัวอักษร',
        'array' => ':attribute ต้องมีระหว่าง :min และ :max รายการ',
    ],

    'boolean' => 'ฟิลด์ :attribute ต้องเป็นค่าจริงหรือเท็จเท่านั้น',
    'confirmed' => 'การยืนยัน :attribute ไม่ตรงกัน',
    'current_password' => 'รหัสผ่านไม่ถูกต้อง',
    'date' => ':attribute ไม่ใช่วันที่ที่ถูกต้อง',
    'date_equals' => ':attribute ต้องเป็นวันที่เท่ากับ :date',
    'date_format' => ':attribute ไม่ตรงกับรูปแบบ :format',
    'declined' => ':attribute ต้องถูกปฏิเสธ',
    'declined_if' => ':attribute ต้องถูกปฏิเสธเมื่อ :other เป็น :value',
    'different' => ':attribute และ :other ต้องไม่เหมือนกัน',
    'digits' => ':attribute ต้องมี :digits หลัก',
    'digits_between' => ':attribute ต้องมีความยาวระหว่าง :min และ :max หลัก',
    'dimensions' => ':attribute มีขนาดไม่ถูกต้อง',
    'distinct' => 'ฟิลด์ :attribute มีค่าที่ซ้ำกัน',
    'email' => ':attribute ต้องเป็นที่อยู่อีเมลที่ถูกต้อง',
    'ends_with' => ':attribute ต้องลงท้ายด้วยหนึ่งในตัวเลือกเหล่านี้: :values',
    'enum' => ':attribute ที่เลือกไม่ถูกต้อง',
    'exists' => ':attribute ที่เลือกไม่ถูกต้อง',
    'file' => ':attribute ต้องเป็นไฟล์',
    'filled' => 'ฟิลด์ :attribute ต้องมีค่า',

    'gt' => [
        'numeric' => 'ข้อมูล :attribute ต้องมีค่ามากกว่า :value',
        'file' => 'ข้อมูล :attribute ต้องมีขนาดใหญ่กว่า :value กิโลไบต์',
        'string' => 'ข้อมูล :attribute ต้องมีตัวอักษรมากกว่า :value ตัว',
        'array' => 'ข้อมูล :attribute ต้องมีรายการมากกว่า :value รายการ',
    ],
    'gte' => [
        'numeric' => 'ข้อมูล :attribute ต้องมีค่ามากกว่าหรือเท่ากับ :value',
        'file' => 'ข้อมูล :attribute ต้องมีขนาดใหญ่กว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => 'ข้อมูล :attribute ต้องมีตัวอักษรมากกว่าหรือเท่ากับ :value ตัว',
        'array' => 'ข้อมูล :attribute ต้องมีรายการ :value รายการหรือมากกว่า',
    ],
    'image' => 'ข้อมูล :attribute ต้องเป็นรูปภาพ',
    'in' => 'ข้อมูลที่เลือก :attribute ไม่ถูกต้อง',
    'in_array' => 'ข้อมูล :attribute ไม่มีอยู่ใน :other',
    'integer' => 'ข้อมูล :attribute ต้องเป็นจำนวนเต็ม',
    'ip' => 'ข้อมูล :attribute ต้องเป็น IP address ที่ถูกต้อง',
    'ipv4' => 'ข้อมูล :attribute ต้องเป็น IPv4 address ที่ถูกต้อง',
    'ipv6' => 'ข้อมูล :attribute ต้องเป็น IPv6 address ที่ถูกต้อง',
    'mac_address' => 'ข้อมูล :attribute ต้องเป็น MAC address ที่ถูกต้อง',
    'json' => 'ข้อมูล :attribute ต้องเป็น JSON string ที่ถูกต้อง',
    'lt' => [
        'numeric' => 'ข้อมูล :attribute ต้องมีค่าน้อยกว่า :value',
        'file' => 'ข้อมูล :attribute ต้องมีขนาดเล็กกว่า :value กิโลไบต์',
        'string' => 'ข้อมูล :attribute ต้องมีตัวอักษรน้อยกว่า :value ตัว',
        'array' => 'ข้อมูล :attribute ต้องมีรายการน้อยกว่า :value รายการ',
    ],

    'lte' => [
        'numeric' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => ':attribute ต้องมีตัวอักษรไม่เกิน :value ตัว',
        'array' => ':attribute ต้องมีสมาชิกไม่เกิน :value ตัว',
    ],
    'max' => [
        'numeric' => ':attribute ต้องไม่เกิน :max',
        'file' => ':attribute ต้องมีขนาดไม่เกิน :max กิโลไบต์',
        'string' => ':attribute ต้องมีตัวอักษรไม่เกิน :max ตัว',
        'array' => ':attribute ต้องมีสมาชิกไม่เกิน :max ตัว',
    ],
    'mimes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'min' => [
        'numeric' => ':attribute ต้องมีค่าอย่างน้อย :min',
        'file' => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์',
        'string' => ':attribute ต้องมีตัวอักษรอย่างน้อย :min ตัว',
        'array' => ':attribute ต้องมีสมาชิกอย่างน้อย :min ตัว',
    ],

    'multiple_of' => 'ค่า :attribute ต้องเป็นเลขคู่ของ :value',
    'not_in' => 'ค่าที่เลือก :attribute ไม่ถูกต้อง',
    'not_regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'numeric' => ':attribute ต้องเป็นตัวเลข',
    'password' => 'รหัสผ่านไม่ถูกต้อง',
    'present' => 'ค่า :attribute ต้องมีอยู่',
    'prohibited' => 'ไม่อนุญาตให้ใช้ :attribute',
    'prohibited_if' => 'ไม่อนุญาตให้ใช้ :attribute เมื่อ :other เป็น :value',
    'prohibited_unless' => 'ไม่อนุญาตให้ใช้ :attribute น้อยกว่า :other ไม่ได้อยู่ใน :values',
    'prohibits' => 'ไม่อนุญาตให้ใช้ :attribute ถ้า :other มีการระบุไว้',
    'regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'required' => 'จำเป็นต้องกรอก :attribute',
    'required_if' => 'จำเป็นต้องกรอก :attribute เมื่อ :other เป็น :value',
    'required_unless' => 'จำเป็นต้องกรอก :attribute ถ้า :other ไม่ได้อยู่ใน :values',
    'required_with' => 'จำเป็นต้องกรอก :attribute เมื่อ :values มีการระบุไว้',
    'required_with_all' => 'จำเป็นต้องกรอก :attribute เมื่อ :values มีการระบุไว้ทั้งหมด',
    'required_without' => 'จำเป็นต้องกรอก :attribute เมื่อ :values ไม่ได้ระบุไว้',
    'required_without_all' => 'จำเป็นต้องกรอก :attribute เมื่อไม่มีค่าใดค่าหนึ่งใน :values ที่ระบุไว้',
    'same' => ':attribute และ :other ต้องตรงกัน',
    'size' => [
        'numeric' => ':attribute ต้องเป็น :size',
        'file' => ':attribute ต้องมีขนาด :size กิโลไบต์',
        'string' => ':attribute ต้องมีความยาว :size ตัวอักษร',
        'array' => ':attribute ต้องมีจำนวน :size รายการ',
    ],
    'starts_with' => 'ข้อมูล :attribute ต้องเริ่มต้นด้วยข้อใดข้อหนึ่งจาก: :values',
    'string' => 'ข้อมูล :attribute ต้องเป็นข้อความ',
    'timezone' => 'ข้อมูล :attribute ต้องเป็นโซนเวลาที่ถูกต้อง',
    'unique' => 'ข้อมูล :attribute ถูกใช้งานไปแล้ว',
    'uploaded' => 'ไม่สามารถอัพโหลดไฟล์ :attribute ได้',
    'url' => 'ข้อมูล :attribute ต้องเป็น URL ที่ถูกต้อง',
    'uuid' => 'ข้อมูล :attribute ต้องเป็น UUID ที่ถูกต้อง',


    'validation_password_mixed' => 'รหัสผ่าน :attribute ต้องมีตัวอักษรอย่างน้อยหนึ่งตัวใหญ่และหนึ่งตัวเล็ก',
    'validation_password_letters' => 'รหัสผ่าน :attribute ต้องมีตัวอักษรอย่างน้อยหนึ่งตัว',
    'validation_password_symbols' => 'รหัสผ่าน :attribute ต้องมีสัญลักษณ์อย่างน้อยหนึ่งตัว',
    'validation_password_numbers' => 'รหัสผ่าน :attribute ต้องมีตัวเลขอย่างน้อยหนึ่งตัว',
    'validation_password_uncompromised' => ':attribute ที่กำหนดไว้มีการเปิดเผยข้อมูลในการรั่วไหลของข้อมูล โปรดเลือก :attribute อื่น',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'ข้อความที่กำหนดเอง',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
?>
