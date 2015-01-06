<?php

/**
 * @datetime($var)
 * formats the value as a datetime string
 */
Blade::extend(function($view, $compiler)
{
    $pattern = $compiler->createMatcher('datetime');
    return preg_replace($pattern, '$1<?php echo \Carbon::parse($2)->format(\'d M, Y H:i\'); ?>', $view);
});

/**
 * @toBTC($var)
 * formats the satoshi value as a Bitcoin string
 */
Blade::extend(function($view, $compiler)
{
    $pattern = $compiler->createMatcher('toBTC');
    return preg_replace($pattern, '$1<?php echo Blocktrail::toBTCString($2); ?>', $view);
});
