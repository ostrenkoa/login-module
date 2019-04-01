<?php
/**
 * The placeholders configuration
 *
 * @package go\DB
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

return array(
    /* The list of placeholders (the main short form) */
    'placeholders' => array(
        '', 'l', 's', 'v', 't', 'c', 'e', 'q', 'w', 'xc', 'o',
    ),

    /* The list of long synonyms */
    'longs' => array(
        'string' => 'string',
        'scalar' => '',
        'list'   => 'l',
        'set'    => 's',
        'values' => 'v',
        'table'  => 't',
        'col'    => 'c',
        'escape' => 'e',
        'query'  => 'q',
        'where'  => 'w',
        'cols'   => 'xc',
        'order'  => 'o',
    ),

    /* The list of modifiers (the main short form) */
    'modifiers' => array(
        'n', 'i', 'f', 'b',
    ),

    /* The list of long synonyms of modifiers */
    'longModifiers' => array(
        'null'  => 'n',
        'int'   => 'i',
        'float' => 'f',
        'bool'  => 'b',
    ),
);
