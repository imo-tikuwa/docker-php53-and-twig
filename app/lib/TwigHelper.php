<?php

/**
 * twig使うためのヘルパー
 */
class TwigHelper
{
    private $twig = null;
    private $template_dir = null;
    private $template = null;
    private $template_params = null;
    private $twig_ext = '.twig';
    private $is_render = false;

    /**
     * コンストラクタ
     * @param string $template_dir 使用するtwigテンプレートを含むディレクトリ
     * 未指定のときdebug_backtraceから呼び出し元のプログラムのいっこ上のtemplatesディレクトリを参照する
     *
     * @param string $template 使用するtwigテンプレート
     * 未指定のときdebug_backtraceから呼び出し元のプログラム名のtwigを参照する設定を行う
     *
     * twigはdump()を使用可能とする
     */
    public function __construct($template_dir = null, $template = null)
    {
        $traces = debug_backtrace();

        // テンプレートディレクトリを設定
        if (is_null($template_dir)) {
            $template_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        }
        $this->setTemplateDir($template_dir);

        // テンプレート名を設定
        if (is_null($template)) {
            $src_file_name = pathinfo($traces[0]['file'], PATHINFO_FILENAME);
            $template = $src_file_name . $this->twig_ext;
        } elseif (!ends_with($template, $this->twig_ext)) {
            throw new Exception("The template file must have a {$this->twig_ext} extension.");
        }
        $this->setTemplate($template);

        // デフォルトのテンプレートパラメータをセットする
        $this->setDefaultTemplateParams();

        $this->twig = new Twig_Environment(new Twig_Loader_Filesystem($this->template_dir), array(
            'debug' => true,
        ));
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    /**
     * デストラクタ
     * twigのrender()を実行する
     */
    public function __destruct()
    {
        if (!$this->is_render) {
            echo $this->twig->loadTemplate($this->template)->render($this->template_params);
        }
    }

    /**
     * twigテンプレートをセットする
     * @param string $template twigテンプレート名
     */
    public function setTemplate($template)
    {
        if (!file_exists($this->template_dir . $template)) {
            throw new Exception(sprintf("template not found. [%s%s]", $this->template_dir, $template));
        }
        $this->template = $template;
    }

    /**
     * twigテンプレートのディレクトリをセットする
     * @param string $template_dir twigテンプレートがあるディレクトリ
     */
    public function setTemplateDir($template_dir)
    {
        if (!ends_with($template_dir, DIRECTORY_SEPARATOR)) {
            $template_dir .= DIRECTORY_SEPARATOR;
        }
        $this->template_dir = $template_dir;
    }

    /**
     * twigテンプレートのパラメータをセットする
     * @param array $template_params twig内で展開するパラメータ配列
     */
    public function setTemplateParams($template_params)
    {
        $this->template_params = array_merge($this->template_params, $template_params);
    }

    /**
     * デフォルトのテンプレートパラメータをセットする
     * テンプレートパラメータについて初期状態でリクエスト情報とセッションは扱えるようにする
     */
    private function setDefaultTemplateParams()
    {
        $template_params = array();
        // php5.3なのでセッションが開始してるかはsession_id()で判定
        if (session_id() !== '') {
            $template_params['session'] = $_SESSION;
        }
        $template_params['request'] = $_REQUEST;
        $this->template_params = $template_params;
    }

    /**
     * 手動レンダリング
     * @param bool $return trueのときechoじゃなくてreturnする
     * @return string
     */
    public function render($return = false)
    {
        $this->is_render = true;
        $this->twig->loadTemplate($this->template);
        if ($return) {
            return $this->twig->render($this->template_params);
        } else {
            echo $this->twig->render($this->template_params);
        }
    }
}