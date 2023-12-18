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

    'accepted' => ':Attribute harus diterima.',
    'accepted_if' => ':Attribute harus diterima ketika :other adalah :value.',
    'active_url' => ':Attribute bukan URL yang valid.',
    'after' => ':Attribute harus tanggal setelah :date.',
    'after_or_equal' => ':Attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => ':Attribute harus hanya mengandung huruf.',
    'alpha_dash' => ':Attribute harus hanya mengandung huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => ':Attribute harus hanya mengandung huruf dan angka.',
    'array' => ':Attribute harus berupa sebuah array.',
    'before' => ':Attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':Attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':Attribute harus antara :min dan :max.',
        'file' => ':Attribute harus antara :min dan :max kilobita.',
        'string' => ':Attribute harus antara :min dan :max karakter.',
        'array' => ':Attribute harus memiliki antara :min dan :max item.',
    ],

    'boolean' => 'Bidang :attribute harus benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Password salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berupa tanggal sama dengan :date.',
    'date_format' => ':attribute tidak cocok dengan format :format.',
    'declined' => 'Bidang :attribute harus ditolak.',
    'declined_if' => 'Bidang :attribute harus ditolak saat :other adalah :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus :digits digit.',
    'digits_between' => ':attribute harus memiliki antara :min dan :max digit.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Bidang :attribute memiliki nilai duplikat.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa file.',
    'filled' => 'Bidang :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file' => ':attribute harus lebih besar dari :value kilobyte.',
        'string' => ':attribute harus lebih besar dari :value karakter.',
        'array' => ':attribute harus memiliki lebih dari :value item.',
    ],

    'gte' => [
        'numeric' => 'Nilai :attribute harus lebih besar atau sama dengan :value.',
        'file' => 'Ukuran :attribute harus lebih besar atau sama dengan :value kilobita.',
        'string' => 'Panjang :attribute harus lebih besar atau sama dengan :value karakter.',
        'array' => 'Jumlah item pada :attribute harus :value atau lebih.',
    ],
    'image' => ':attribute harus berupa gambar.',
    'in' => 'Nilai yang dipilih pada :attribute tidak valid.',
    'in_array' => 'Nilai pada :attribute tidak ada dalam :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'json' => ':attribute harus berupa string JSON yang valid.',
    'lt' => [
        'numeric' => 'Nilai :attribute harus kurang dari :value.',
        'file' => 'Ukuran :attribute harus kurang dari :value kilobita.',
        'string' => 'Panjang :attribute harus kurang dari :value karakter.',
        'array' => 'Jumlah item pada :attribute harus kurang dari :value.',
    ],
    'lte' => [
        'numeric' => 'Nilai :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Ukuran :attribute harus kurang dari atau sama dengan :value kilobita.',
        'string' => 'Panjang :attribute harus kurang dari atau sama dengan :value karakter.',
        'array' => 'Jumlah item pada :attribute tidak boleh lebih dari :value.',
    ],

    'max' => [
        'numeric' => ':Attribute tidak boleh lebih besar dari :max.',
        'file' => ':Attribute tidak boleh lebih besar dari :max kilobita.',
        'string' => ':Attribute tidak boleh lebih besar dari :max karakter.',
        'array' => ':Attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => ':Attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => ':Attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => ':Attribute harus minimal :min.',
        'file' => ':Attribute harus berukuran minimal :min kilobita.',
        'string' => ':Attribute harus memiliki minimal :min karakter.',
        'array' => ':Attribute harus memiliki minimal :min item.',
    ],
    'multiple_of' => ':Attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':Attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':Attribute harus berupa angka.',
    'password' => 'Kata sandi tidak benar.',
    'present' => 'Bidang :attribute harus ada.',
    'prohibited' => 'Bidang :attribute tidak diizinkan.',
    'prohibited_if' => 'Bidang :attribute tidak diizinkan jika :other adalah :value.',
    'prohibited_unless' => 'Bidang :attribute tidak diizinkan kecuali :other berada dalam :values.',
    'prohibits' => 'Bidang :attribute melarang keberadaan :other.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => 'Bidang :attribute wajib diisi.',
    'required_if' => 'Bidang :attribute wajib diisi jika :other adalah :value.',
    'required_unless' => 'Bidang :attribute wajib diisi kecuali :other berada dalam :values.',
    'required_with' => 'Bidang :attribute wajib diisi jika :values ada.',
    'required_with_all' => 'Bidang :attribute wajib diisi jika semua :values ada.',
    'required_without' => 'Bidang :attribute wajib diisi jika :values tidak ada.',
    'required_without_all' => 'Bidang :attribute wajib diisi jika tidak ada :values sama sekali.',
    'same' => ':Attribute dan :other harus sama.',
    'size' => [
        'numeric' => ':Attribute harus berukuran :size.',
        'file' => ':Attribute harus berukuran :size kilobita.',
        'string' => ':Attribute harus memiliki :size karakter.',
        'array' => ':Attribute harus memiliki :size item.',
    ],
    'starts_with' => 'Kolom :attribute harus diawali dengan salah satu dari: :values.',
    'string' => 'Kolom :attribute harus berupa teks.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah digunakan.',
    'uploaded' => 'Gagal mengunggah berkas pada kolom :attribute.',
    'url' => 'Kolom :attribute harus berupa URL yang valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    'validation_password_mixed' => 'Kolom :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
    'validation_password_letters' => 'Kolom :attribute harus mengandung setidaknya satu huruf.',
    'validation_password_symbols' => 'Kolom :attribute harus mengandung setidaknya satu simbol.',
    'validation_password_numbers' => 'Kolom :attribute harus mengandung setidaknya satu angka.',
    'validation_password_uncompromised' => ':attribute yang diberikan telah muncul dalam kebocoran data. Silakan pilih :attribute yang berbeda.',

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
        'nama-attribute' => [
            'nama-aturan' => 'pesan-khusus',
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
