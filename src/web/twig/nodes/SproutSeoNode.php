<?php
/**
 * @link https://sprout.barrelstrengthdesign.com
 * @copyright Copyright (c) Barrel Strength Design LLC
 * @license https://craftcms.github.io/license
 */

namespace barrelstrength\sproutseo\web\twig\nodes;

use barrelstrength\sproutseo\SproutSeo;
use Twig_Compiler;
use Twig_Node;

class SproutSeoNode extends Twig_Node
{
    /**
     * Compiles a Optimize_Node into PHP.
     *
     * @param \Twig_Compiler $compiler
     */
    public function compile(Twig_Compiler $compiler)
    {
        $action = $this->getNode('action')->getAttribute('value');

        if ($action == 'optimize') {
            $compiler
                ->addDebugInfo($this)
                ->write('echo '.SproutSeo::class."::\$app->optimize->getMetadataViaContext(\$context);\n\n");
        }
    }
}
