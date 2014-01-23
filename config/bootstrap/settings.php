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

Settings::register('cms_core', 'project.name', PROJECT_NAME);
Settings::register('cms_core', 'project.version', PROJECT_VERSION);

Settings::register('cms_core', 'site.title', 'Application');

// FIXME Use a pseudo number generator seeded with project
// name to generate cookie secret. Simple md5'ing wont work as
// there the alphabet would be too limited for a password style string.
Settings::register('cms_core', 'security.cookieSecret', 'alsFDDT§$sdfs');

Settings::register('cms_core', 'contact.default.name', 'Example');
Settings::register('cms_core', 'contact.default.email', 'mail@example.com');
Settings::register('cms_core', 'contact.default.phone', '+49 (0) 12 345 678');

Settings::register('cms_core', 'contact.exec.name', 'Atelier Disko');
Settings::register('cms_core', 'contact.exec.email', 'mail@atelierdisko.de');
Settings::register('cms_core', 'contact.exec.phone', '+49 (0) 12 345 678');

?>