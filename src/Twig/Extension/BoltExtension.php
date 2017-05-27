<?php

namespace Bolt\Twig\Extension;

use Bolt;
use Bolt\Config;
use Bolt\Storage\EntityManagerInterface;
use Bolt\Twig\SetcontentTokenParser;
use Bolt\Twig\SwitchTokenParser;
use Twig_Extension as Extension;
use Twig_Extension_GlobalsInterface as GlobalsInterface;
use Twig_Filter as TwigFilter;
use Twig_Function as TwigFunction;

/**
 * Bolt base Twig functionality and definitions.
 */
class BoltExtension extends Extension implements GlobalsInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var Config */
    private $config;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em
     * @param Config                 $config
     */
    public function __construct(EntityManagerInterface $em, Config $config)
    {
        $this->em = $em;
        $this->config = $config;
    }

    /**
     * Used by setcontent tag.
     *
     * @return EntityManagerInterface
     */
    public function getStorage()
    {
        return $this->em;
    }

    /**
     * {@inheritdoc}
     *
     * As of Twig 2.x, the ability to register a global variable after runtime
     * or the extensions have been initialized will not be possible any longer,
     * but changing the value of an already registered global is possible.
     */
    public function getGlobals()
    {
        return [
            'frontend'     => null,
            'backend'      => null,
            'async'        => null,
            'theme'        => null,
            'user'         => null,
            'users'        => null,
            'config'       => $this->config,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        $parsers = [
            new SetcontentTokenParser(),
            new SwitchTokenParser(),
        ];

        return $parsers;
    }
}
