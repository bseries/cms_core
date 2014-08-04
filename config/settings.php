<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use cms_core\extensions\cms\Settings;
use cms_core\extensions\cms\Features;

Settings::register('cms_core', 'project.name', PROJECT_NAME);
Settings::register('cms_core', 'project.version', PROJECT_VERSION);
Settings::register('cms_core', 'site.title');

// FIXME Use a pseudo number generator seeded with project
// name to generate cookie secret. Simple md5'ing wont work as
// there the alphabet would be too limited for a password style string.
Settings::register('cms_core', 'security.cookieSecret', 'alsFDDT§$sdfs');

Settings::register('cms_core', 'contact.default.name', 'Acme Inc.');
Settings::register('cms_core', 'contact.default.type', 'organization'); // organization or person
Settings::register('cms_core', 'contact.default.email', 'mail@example.com');
Settings::register('cms_core', 'contact.default.phone', '+49 (0) 12 345 678');
Settings::register('cms_core', 'contact.default.city', 'Las Vegas');

Settings::register('cms_core', 'contact.exec.name', 'Atelier Disko');
Settings::register('cms_core', 'contact.exec.type', 'organization');
Settings::register('cms_core', 'contact.exec.email', 'info@atelierdisko.de');
Settings::register('cms_core', 'contact.exec.phone', '+49 (0) 40 355 618 96');
Settings::register('cms_core', 'contact.exec.website', 'http://atelierdisko.de');
Settings::register('cms_core', 'contact.exec.postal_code', 'D-20359');
Settings::register('cms_core', 'contact.exec.street_address', 'Budapester Straße 49');
Settings::register('cms_core', 'contact.exec.city', 'Hamburg');
Settings::register('cms_core', 'contact.exec.country', 'Germany');
Settings::register('cms_core', 'contact.exec.district', 'St. Pauli');

Settings::register('cms_core', 'service.googleAnalytics.default.account');
Settings::register('cms_core', 'service.googleAnalytics.default.domain');
Settings::register('cms_core', 'service.googleAnalytics.default.propertyId');

Settings::register('cms_core', 'user.number', [
	'sort' => '/([0-9]{4}-[0-9]{4})/',
	'extract' => '/[0-9]{4}-([0-9]{4})/',
	'generate' => '%Y-%%04.d'
]);

Settings::register('cms_core', 'availableCountries', [
	'DE', 'US', 'CA'
]);

Settings::register('cms_core', 'availableCurrencies', [
	'EUR', 'USD'
]);

Features::register('cms_core', 'useNewGoogleAnalyticsTrackingCode', true);
Features::register('cms_core', 'useBilling', false);
Features::register('cms_core', 'user.sendActivationMail', false);

?>