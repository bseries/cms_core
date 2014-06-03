<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use cms_core\extensions\cms\Settings;
use cms_core\extensions\cms\Features;

Settings::register('contact.default.name', 'Acme Inc.');
Settings::register('contact.default.type', 'organization');
Settings::register('contact.default.email', 'mail@example.com');
Settings::register('contact.default.phone', '+49 (0) 12 345 678');

Settings::register('contact.exec.name', 'Atelier Disko');
Settings::register('contact.exec.type', 'organization');
Settings::register('contact.exec.email', 'info@atelierdisko.de');
Settings::register('contact.exec.phone', '+49 (0) 40 355 618 96');
Settings::register('contact.exec.website', 'http://atelierdisko.de');
Settings::register('contact.exec.postal_code', 'D-20359');
Settings::register('contact.exec.street_address', 'Budapester Straße 49');
Settings::register('contact.exec.city', 'Hamburg');
Settings::register('contact.exec.country', 'Germany');
Settings::register('contact.exec.district', 'St. Pauli');

Settings::register('availableCurrencies', [
	'EUR'
]);
Settings::register('availableCountries', [
	'DE'
]);

Features::register('cms_core', 'useNewGoogleAnalyticsTrackingCode', true);
Features::register('cms_core', 'useBilling', false);
Features::register('cms_core', 'user.sendActivationMail', false);

?>