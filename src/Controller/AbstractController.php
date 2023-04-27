<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    public const FILTERS = [
        'string' => FILTER_UNSAFE_RAW,
        'string[]' => [
            'filter' => FILTER_UNSAFE_RAW,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_SCALAR
        ],
        'int[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'float' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'float[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'date' => FILTER_UNSAFE_RAW
    ];
    public const VALIDATERS = [
        'string' => FILTER_UNSAFE_RAW,
        'string[]' => [
            'filter' => FILTER_UNSAFE_RAW,
            'flag' => FILTER_REQUIRE_ARRAY
        ],
        'email' => FILTER_VALIDATE_EMAIL,
        'int' => [
            'filter' => FILTER_VALIDATE_INT,
            'flag' => FILTER_REQUIRE_SCALAR
        ],
        'int[]' => [
            'filter' => FILTER_VALIDATE_INT,
            'flag' => FILTER_REQUIRE_ARRAY
            ],
        'float' => [
            'filter' => FILTER_VALIDATE_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'float[]' => [
            'filter' => FILTER_VALIDATE_FLOAT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'date' => FILTER_UNSAFE_RAW
    ];
    public const FIELDS = [];
    protected Environment $twig;
    protected array | false $user;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());
        $userManager = new UserManager();
        $this->user = isset($_SESSION['user_id']) ? $userManager->selectOneById($_SESSION['user_id']) : false;
        $this->twig->addGlobal('user', $this->user);
    }

    public function arrayTrim(array $inputs): array
    {
        return array_map(function ($input) {
            if (is_string($input)) {
                return trim($input);
            } elseif (is_array($input)) {
                return $this->arrayTrim($input);
            } else {
                return $input;
            }
        }, $inputs);
    }

    public function sanitizeData(
        array $inputs,
        array $fields = [],
        int $defaultFilter = FILTER_UNSAFE_RAW,
        array $filters = self::FILTERS
    ): array {
        if ($fields) {
            $options = array_map(fn($field) => $filters[$field], $fields);
            var_dump($options);
            $data = filter_var_array($inputs, $options);
            var_dump($data);
        } else {
            $data = filter_var_array($inputs, $defaultFilter);
        }

        return $data;
    }
    public function validateData(
        array $inputs,
        array $fields = [],
        int $defaultFilter = FILTER_UNSAFE_RAW,
        array $validaters = self::VALIDATERS
    ): array {
        if ($fields) {
            $options = array_map(fn($field) => $validaters[$field], $fields);
            $data = filter_var_array($inputs, $options);
        } else {
            $data = filter_var_array($inputs, $defaultFilter);
        }
        return $data;
    }
}
