<?php

namespace simpleflake;

/**
 * @var int
 */
const EPOCH = 946702800;

/**
 * @var int
 */
const TIMESTAMP_LENGTH = 41;

/**
 * @var int
 */
const TIMESTAMP_SHIFT = 23;

/**
 * @var int
 */
const RANDOM_LENGTH = 23;

/**
 * @var int
 */
const RANDOM_SHIFT = 0;

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
    $timestamp = ($timestamp) ? $timestamp : microtime(true);
    $timestamp -= $epoch;
    $timestamp = (int) ($timestamp * 1000);

    if ($randomBits !== null) {
        // use given random bits
    } else if (function_exists("mt_rand")) {
        $randomBits = mt_rand() * RANDOM_LENGTH;
    } else {
        $randomBits = rand() * RANDOM_LENGTH;
    }

    return ($timestamp << TIMESTAMP_SHIFT) + $randomBits;
}

/**
 * Extract a portion of a bit string. Similar to substr().
 *
 * @param int $data
 * @param int $shift
 * @param int $length
 * @return int
 */
function extract_bits($data, $shift, $length)
{
    $mask = ((1 << $length) - 1) << $shift;
    return (($data & $mask) >> $shift);
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
    $timestamp = extract_bits($flake, TIMESTAMP_SHIFT, TIMESTAMP_LENGTH) / 1000;
    $randomBits = extract_bits($flake, RANDOM_SHIFT, RANDOM_LENGTH);

    return array(
        "timestamp" => $timestamp + $epoch,
        "randomBits" => $randomBits
    );
}
