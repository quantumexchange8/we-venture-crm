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

    'accepted' => ':attribute必须接受。',
    'accepted_if' => '当:other是:value时，:attribute必须接受。',
    'active_url' => ':attribute不是一个有效的URL。',
    'after' => ':attribute必须是:date之后的日期。',
    'after_or_equal' => ':attribute必须是:date之后或等于:date的日期。',
    'alpha' => ':attribute只能包含字母。',
    'alpha_dash' => ':attribute只能包含字母、数字、短横线和下划线。',
    'alpha_num' => ':attribute只能包含字母和数字。',
    'array' => ':attribute必须是一个数组。',
    'before' => ':attribute必须是:date之前的日期。',
    'before_or_equal' => ':attribute必须是:date之前或等于:date的日期。',
    'between' => [
        'numeric' => ':attribute必须介于:min和:max之间。',
        'file' => ':attribute必须介于:min和:max千字节之间。',
        'string' => ':attribute必须介于:min和:max个字符之间。',
        'array' => ':attribute必须有:min到:max个项。',
    ],
    'boolean' => ':attribute字段必须为真或假。',
    'confirmed' => ':attribute确认不匹配。',
    'current_password' => '密码不正确。',
    'date' => ':attribute不是一个有效的日期。',
    'date_equals' => ':attribute必须是等于:date的日期。',
    'date_format' => ':attribute不匹配格式:format。',
    'declined' => ':attribute必须被拒绝。',
    'declined_if' => '当:other是:value时，:attribute必须被拒绝。',
    'different' => ':attribute和:other必须不同。',
    'digits' => ':attribute必须是:digits位数字。',
    'digits_between' => ':attribute必须介于:min和:max位数字之间。',
    'dimensions' => ':attribute具有无效的图像尺寸。',
    'distinct' => ':attribute字段具有重复值。',
    'email' => ':attribute必须是一个有效的电子邮件地址。',
    'ends_with' => ':attribute必须以以下之一结尾: :values。',
    'enum' => '所选的:attribute无效。',
    'exists' => '所选的:attribute无效。',
    'file' => ':attribute必须是一个文件。',
    'filled' => ':attribute字段必须有一个值。',
    'gt' => [
        'numeric' => ':attribute必须大于:value。',
        'file' => ':attribute必须大于:value千字节。',
        'string' => ':attribute必须大于:value个字符。',
        'array' => ':attribute必须有:value项以上。',
    ],
    'gte' => [
        'numeric' => ':attribute 必须大于等于 :value。',
        'file' => ':attribute 必须大于等于 :value 千字节。',
        'string' => ':attribute 必须大于等于 :value 个字符。',
        'array' => ':attribute 必须有 :value 个项目或更多。',
    ],
    'image' => ':attribute 必须是一张图片。',
    'in' => '所选的 :attribute 无效。',
    'in_array' => ':attribute 字段在 :other 中不存在。',
    'integer' => ':attribute 必须是一个整数。',
    'ip' => ':attribute 必须是一个有效的 IP 地址。',
    'ipv4' => ':attribute 必须是一个有效的 IPv4 地址。',
    'ipv6' => ':attribute 必须是一个有效的 IPv6 地址。',
    'mac_address' => ':attribute 必须是一个有效的 MAC 地址。',
    'json' => ':attribute 必须是一个有效的 JSON 字符串。',
    'lt' => [
        'numeric' => ':attribute 必须小于 :value。',
        'file' => ':attribute 必须小于 :value 千字节。',
        'string' => ':attribute 必须小于 :value 个字符。',
        'array' => ':attribute 必须少于 :value 个项目。',
    ],
    'lte' => [
        'numeric' => ':attribute 必须小于等于 :value。',
        'file' => ':attribute 必须小于等于 :value 千字节。',
        'string' => ':attribute 必须小于等于 :value 个字符。',
        'array' => ':attribute 不能有超过 :value 个项目。',
    ],
    'max' => [
        'numeric' => ':attribute 不能大于 :max。',
        'file' => ':attribute 不能大于 :max 千字节。',
        'string' => ':attribute 不能大于 :max 个字符。',
        'array' => ':attribute 不能有超过 :max 个项目。',
    ],
    'mimes' => ':attribute 必须是类型为 :values 的文件。',
    'mimetypes' => ':attribute 必须是类型为 :values 的文件。',
    'min' => [
        'numeric' => ':attribute 必须至少为 :min。',
        'file' => ':attribute 必须至少为 :min 千字节。',
        'string' => ':attribute 必须至少为 :min 个字符。',
        'array' => ':attribute 必须至少有 :min 个项目。',
    ],
    'multiple_of' => ':attribute 必须是 :value 的倍数。',
    'not_in' => ':attribute 的选择无效。',
    'not_regex' => ':attribute 格式无效。',
    'numeric' => ':attribute 必须是一个数字。',
    'password' => '密码不正确。',
    'present' => ':attribute 字段必须存在。',
    'prohibited' => ':attribute 字段被禁止。',
    'prohibited_if' => '当 :other 为 :value 时，:attribute 字段被禁止。',
    'prohibited_unless' => '除非 :other 在 :values 中，否则 :attribute 字段被禁止。',
    'prohibits' => ':attribute 字段禁止存在 :other。',
    'regex' => ':attribute 格式无效。',
    'required' => ':attribute 字段是必填的。',
    'required_if' => '当 :other 为 :value 时，:attribute 字段是必填的。',
    'required_unless' => '除非 :other 在 :values 中，否则 :attribute 字段是必填的。',
    'required_with' => '当 :values 存在时，:attribute 字段是必填的。',
    'required_with_all' => '当 :values 都存在时，:attribute 字段是必填的。',
    'required_without' => '当 :values 不存在时，:attribute 字段是必填的。',
    'required_without_all' => '当 :values 都不存在时，:attribute 字段是必填的。',
    'same' => ':attribute 和 :other 必须匹配。',
    'size' => [
        'numeric' => ':attribute 必须是 :size。',
        'file' => ':attribute 必须是 :size 千字节。',
        'string' => ':attribute 必须是 :size 个字符。',
        'array' => ':attribute 必须包含 :size 个项目。',
    ],
    'starts_with' => ':attribute 必须以以下之一开头：:values。',
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已经被占用。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 必须是一个有效的 URL。',
    'uuid' => ':attribute 必须是一个有效的 UUID。',

    'validation_password_mixed' => ':attribute 必须至少包含一个大写字母和一个小写字母。',
    'validation_password_letters' => ':attribute 必须包含至少一个字母。',
    'validation_password_symbols' => ':attribute 必须包含至少一个符号。',
    'validation_password_numbers' => ':attribute 必须包含至少一个数字。',
    'validation_password_uncompromised' => '给定的 :attribute 出现在数据泄漏中。请选择不同的 :attribute。',

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
            'rule-name' => 'custom-message',
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
