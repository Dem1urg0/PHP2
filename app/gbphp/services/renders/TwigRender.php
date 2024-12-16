<?php

namespace App\services\renders;

use App\main\App;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TwigRender implements IRender
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader([
            dirname(dirname(__DIR__)) . '/views/layouts',
            dirname(dirname(__DIR__)) . '/views/',
        ]);
        $this->twig = new Environment($loader);

        $currentUser = App::call()->Request->sessionGet('user');
        $this->twig->addGlobal('currentUser', $currentUser);
    }

    public function render($template, $params = [])
    {
        $template .= '.twig';
        try {
            return $this->twig->render($template, $params);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }
    }
}