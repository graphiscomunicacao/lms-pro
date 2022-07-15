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

    'accepted' => 'O :Attribute precisa ser aceito.',
    'accepted_if' => 'O :Attribute precisa ser aceito quando o :other é :value.',
    'active_url' => 'A URL :Attribute é inválida.',
    'after' => 'A data :Attribute deve ser posterior à :date.',
    'after_or_equal' => 'A data :Attribute deve ser igual ou posterior à :date.',
    'alpha' => 'O :Attribute deve conter somente letras.',
    'alpha_dash' => 'O :Attribute deve conter somente letras, números, traços e sublinhados.',
    'alpha_num' => 'O :Attribute deve conter somente letras e números.',
    'array' => 'O :Attribute deve ser uma array.',
    'before' => 'A data :Attribute deve ser anterior à :date.',
    'before_or_equal' => 'A data :Attribute deve ser uma anterior ou igual à :date.',
    'between' => [
        'array' => 'O :Attribute deve ter entre :min e :max itens.',
        'file' => ':Attribute deve pesar entre :min e :max kilobytes.',
        'numeric' => 'O :Attribute deve estar entre :min e :max.',
        'string' => 'O :Attribute deve ter entre :min e :max caracteres.',
    ],
    'boolean' => 'O campo :Attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação de :Attribute não combina.',
    'current_password' => 'A senha está incorreta.',
    'date' => 'A :Attribute é uma data inválida.',
    'date_equals' => 'A data :Attribute deve ser igual à :date',
    'date_format' => 'O :Attribute não está de acordo com o formato :format.',
    'declined' => 'O :Attribute deve ser negado.',
    'declined_if' => 'O :Attribute deve ser negado quando o :other for :valor.',
    'different' => 'Os campos :Attribute e :other devem ser diferentes.',
    'digits' => 'O :Attribute deve ter :digits dígitos.',
    'digits_between' => 'O :Attribute deve ter entre :min e :max dígitos.',
    'dimensions' => 'A imagem :Attribute tem dimensões inválidas.',
    'distinct' => 'O campo :Attribute tem um valor duplicado.',
    'doesnt_start_with' => 'O :Attribute não pode começar com um dos seguintes valores: :values.',
    'email' => 'O :Attribute deve ser um endereço de e-mail válido.',
    'ends_with' => 'O :Attribute deve terminar com um dos seguintes valores: :values.',
    'enum' => 'O :Attribute selecionado é inválido.',
    'exists' => 'O :Attribute selecionado é inválido.',
    'file' => 'O :Attribute deve ser um arquivo.',
    'filled' => 'O :Attribute deve ter um valor.',
    'gt' => [
        'array' => 'O :Attribute deve conter mais de :value items.',
        'file' => ':Attribute deve ter mais de :value kilobytes.',
        'numeric' => 'O :Attribute deve ser maior do que :value.',
        'string' => 'O :Attribute deve ter mais de :value caracteres.',
    ],
    'gte' => [
        'array' => 'O :Attribute deve conter :value itens ou mais.',
        'file' => ':Attribute deve ser maior ou igual à :value kilobytes.',
        'numeric' => 'O :Attribute deve ser maior ou igual à :value.',
        'string' => 'O :Attribute deve ter :value caracteres ou mais.',
    ],
    'image' => 'O :Attribute deve ser uma imagem.',
    'in' => 'O :Attribute selecionado é inválido.',
    'in_array' => 'O campo :Attribute não existe em :other.',
    'integer' => 'O :Attribute deve ser um número inteiro.',
    'ip' => 'O :Attribute deve ser um endereço de IP válido.',
    'ipv4' => 'O :Attribute deve ser um endereço de IPv4 válido',
    'ipv6' => 'O :Attribute deve ser um endereço de IPv6 válido',
    'json' => 'O :Attribute deve ser uma string JSON válida.',
    'lt' => [
        'array' => 'O :Attribute deve conter menos de :value itens.',
        'file' => ':Attribute deve ser menor do que :value kilobytes.',
        'numeric' => 'O :Attribute deve ser menor do que :value.',
        'string' => 'O :Attribute deve conter menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'O :Attribute não pode conter mais de :value itens.',
        'file' => ':Attribute deve ser menor ou igual à :value kilobytes.',
        'numeric' => 'O :Attribute deve ser menor ou igual à :value.',
        'string' => 'O :Attribute deve ter :value caracteres ou menos.',
    ],
    'mac_address' => 'O :Attribute deve ser um endereço MAC válido.',
    'max' => [
        'array' => 'O :Attribute não deve conter mais do que :max itens.',
        'file' => ':Attribute não deve ser maior do que :max kilobytes.',
        'numeric' => 'O :Attribute não deve ser maior do que :max.',
        'string' => 'O :Attribute não deve ter mais do que :max caracteres.',
    ],
    'mimes' => 'O :Attribute deve ser um arquivo dos tipos: :values.',
    'mimetypes' => 'O :Attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'array' => 'O :Attribute deve conter pelo menos :min itens.',
        'file' => ':Attribute deve ter pelo menos :min kilobytes.',
        'numeric' => 'O :Attribute deve ser pelo menos :min.',
        'string' => 'O :Attribute deve ter pelo menos :min caracteres.',
    ],
    'multiple_of' => 'O :Attribute precisa ser um múltiplo de :value.',
    'not_in' => 'O :Attribute selecionado é inválido.',
    'not_regex' => 'O formato de :Attribute é inválido.',
    'numeric' => 'O :Attribute precisa ser um número.',
    'password' => [
        'letters' => 'A :Attribute deve conter pelo menos uma letra.',
        'mixed' => 'A :Attribute deve conter pelo menos uma letra maiúscula e uma letra minúscula.',
        'numbers' => 'A :Attribute deve conter pelo menos um número.',
        'symbols' => 'A :Attribute deve conter pelo menos um caractere especial.',
        'uncompromised' => 'A :Attribute informada apareceu num vazamento de dados. Por gentileza, escolha uma :Attribute diferente.',
    ],
    'present' => 'O campo :Attribute deve estar presente.',
    'prohibited' => 'O campo :Attribute é proibido.',
    'prohibited_if' => 'O campo :Attribute é proibido quando :other for :value.',
    'prohibited_unless' => 'O campo :Attribute é proibido excento quando :other está em :values,',
    'prohibits' => 'O campo :Attribute proibe :other de estar presente.',
    'regex' => 'O formato de :Attribute é inválido.',
    'required' => 'O campo :Attribute é obrigatório.',
    'required_array_keys' => 'O campo :Attribute deve conter entradas para: :values.',
    'required_if' => 'O campo :Attribute é obrigatório quando :other for :value.',
    'required_unless' => 'O campo :Attribute é obrigatório, exceto quando :other estiver em :values.',
    'required_with' => 'O campo :Attribute é obrigatório quando :values estiver presente.',
    'required_with_all' => 'O campo :Attribute é obrigatório quando :values estiverem presentes.',
    'required_without' => 'O campo :Attribute é obrigatório quando :values não estiver presente.',
    'required_without_all' => 'O campo :Attribute é obrigatório quando nenhum dos :values estiverem presentes.',
    'same' => 'O :Attribute e :other devem ser iguais.',
    'size' => [
        'array' => 'O :Attribute deve conter :size items.',
        'file' => ':Attribute deve ter :size kilobytes.',
        'numeric' => 'O :Attribute deve ter :size.',
        'string' => 'O :Attribute deve ter :size caracteres.',
    ],
    'starts_with' => 'O :Attribute não deve começar com nenhum dos seguintes: :values.',
    'string' => 'O :Attribute deve ser uma string.',
    'timezone' => 'O :Attribute deve ser um fuso horário válido.',
    'unique' => 'O :Attribute já foi escolhido.',
    'uploaded' => 'O upload de :Attribute falhou.',
    'url' => 'O :Attribute deve ser uma URL válida.',
    'uuid' => 'O :Attribute deve ser uma UUID válida.',

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
