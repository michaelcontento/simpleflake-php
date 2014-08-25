<?php

namespace Simpleflake;

/**
 * @var int
 */
const EPOCH = 946702800;

/**
 * @var int
 */
const TIMESTAMP_SHIFT = 23;

/**
 * @var int
 */
const RANDOM_MAX_VALUE = 4194303;

/**
 * Generate a 64 bit, roughly-ordered, globally-unique ID.
 *
 * @param int|null $timestamp
 * @param int|null $randomBits
 * @param int $epoch
 * @return int
 */
function generate($timestamp = null, $randomBits = null, $epoch = EPOCH)
{
    $timestamp = ($timestamp !== null) ? $timestamp: microtime(true);
    $timestamp -= $epoch;
    $timestamp *= 1000;
    $timestamp = (int) $timestamp;

    if ($randomBits !== null) {
        $randomBits = (int) $randomBits;
    } else if (function_exists("mt_rand")) {
        $randomBits = mt_rand(0, RANDOM_MAX_VALUE);
    } else {
        $randomBits = (int) rand() * RANDOM_MAX_VALUE;
    }

    $flake = ($timestamp << TIMESTAMP_SHIFT) | $randomBits;
    return $flake;
}

/**
 * Parses a simpleflake and returns a named tuple with the parts.
 *
 * @param int $flake
 * @param int $epoch
 * @return int
 */
function parse($flake, $epoch = EPOCH)
{
    $timestamp = ($flake >> TIMESTAMP_SHIFT) / 1000.0;
    $randomBits = $flake & RANDOM_MAX_VALUE;

    return array(
        "timestamp" => $timestamp + $epoch,
        "randomBits" => $randomBits
    );
}

/**
 * Alias for generate to be "compatible" with the python idol :)
 *
 * @param int|null $timestamp
 * @param int|null $randomBits
 * @param int $epoch
 * @return int
 */
function simpleflake($timestamp = null, $randomBits = null, $epoch = EPOCH)
{
    return generate($timestamp, $randomBits, $epoch);
}

/**
 * Alias for parse to be "compatible" with the python idol :)
 *
 * @param int $flake
 * @param int $epoch
 * @return int
 */
function parse_simpleflake($flake, $epoch = EPOCH)
{
    return parse($flake, $epoch);
}
