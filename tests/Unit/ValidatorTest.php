<?php

it('validates that the passed variable is a string', function () {
    expect(\Core\Validator::string('hello from string validator assertion'))->toBeTrue();
    expect(\Core\Validator::string(123))->toBeTrue();
    expect(\Core\Validator::string(''))->toBeFalse();
});

it('validates that the passed variable is an integer', function () {
    expect(\Core\Validator::integer('hello from string validator assertion'))->toBeFalse();
    expect(\Core\Validator::integer(123))->toBeTrue();
    expect(\Core\Validator::string(''))->toBeFalse();
});

it('validates a correct date format', function () {
    expect(\Core\Validator::date('2024-10-20'))->toBeTrue();
    expect(\Core\Validator::date('2023-01-01'))->toBeTrue();
});

it('invalidates an incorrect date format', function () {
    expect(\Core\Validator::date('2024-20-10'))->toBeFalse();
    expect(\Core\Validator::date('20-10-2024'))->toBeFalse();
    expect(\Core\Validator::date('2024/10/20'))->toBeFalse();
});

it('invalidates non-date strings', function () {
    expect(\Core\Validator::date('hello there!'))->toBeFalse();
    expect(\Core\Validator::date('123'))->toBeFalse();
});

it('validates dates with custom formats', function () {
    expect(\Core\Validator::date('10-20-2024', 'm-d-Y'))->toBeTrue();
    expect(\Core\Validator::date('01-01-2023', 'm-d-Y'))->toBeTrue();
});

it('invalidates dates with custom formats', function () {
    expect(\Core\Validator::date('2024-10-20', 'm-d-Y'))->toBeFalse();
    expect(\Core\Validator::date('20-10-2024', 'm-d-Y'))->toBeFalse();
});

it('validates correct email formats', function () {
    expect(\Core\Validator::email('user@example.com'))->toBeTrue();
    expect(\Core\Validator::email('first.last@example.com'))->toBeTrue();
    expect(\Core\Validator::email('user+name@example.com'))->toBeTrue();
    expect(\Core\Validator::email('user@subdomain.example.com'))->toBeTrue();
    expect(\Core\Validator::email('user@domain.co.uk'))->toBeTrue();
});

it('invalidates incorrect email formats', function () {
    expect(\Core\Validator::email('user@.com'))->toBeFalse();
    expect(\Core\Validator::email('user@com.'))->toBeFalse();
    expect(\Core\Validator::email('@example.com'))->toBeFalse();
    expect(\Core\Validator::email('user@com.123'))->toBeFalse();
    expect(\Core\Validator::email('user@domain..com'))->toBeFalse();
    expect(\Core\Validator::email('user@domain.com.'))->toBeFalse();
    expect(\Core\Validator::email('emailaddress'))->toBeFalse();
    expect(\Core\Validator::email('user@domain,com'))->toBeFalse();
});
