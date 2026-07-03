# Changelog

All notable changes to `laravel-telemaque` will be documented in this file.

## v1.4.13 - 2026-03-27

Upgrade saloonphp/laravel-plugin to v4

## v1.4.12 - 2026-03-12

### What's Changed

* Remove `livewire/livewire` dependency and Wireable usage from DTOs
* Fix PHPStan ignore comments on `paginate()` calls

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.11...v1.4.12

## v1.4.11 - 2025-11-12

### What's Changed

* Update user.json fixture to include 'address_extra' field for agencies by @bnzo in https://github.com/agicom/laravel-telemaque/pull/74

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.10...v1.4.11

## v1.4.10 - 2025-11-12

### What's Changed

* Rename address_2 to address_extra in AgencyDTO by @bnzo in https://github.com/agicom/laravel-telemaque/pull/73

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.9...v1.4.10

## v1.4.9 - 2025-10-07

### What's Changed

* Update GetAgenciesRequest to support multiple codes by @bnzo in https://github.com/agicom/laravel-telemaque/pull/72

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.8...v1.4.9

## v1.4.8 - 2025-07-31

### What's Changed

* chore: update illuminate/contracts requirement to support Laravel 12 by @bnzo in https://github.com/agicom/laravel-telemaque/pull/71

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.7...v1.4.8

## v1.4.7 - 2025-03-06

### What's Changed

* Add EmailCast for casting email property in UserDTO by @dceleste35 in https://github.com/agicom/laravel-telemaque/pull/68
* Add VirtualBranch case to AgencyType enum by @bnzo in https://github.com/agicom/laravel-telemaque/pull/69
* Update dependencies and refactor tests for improved compatibility by @bnzo in https://github.com/agicom/laravel-telemaque/pull/70

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.5...v1.4.7

## 1.4.6 - 2024-12-13

### What's Changed

* Add EmailCast for casting email property in UserDTO by @dceleste35 in https://github.com/agicom/laravel-telemaque/pull/68

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.5...1.4.6

## v1.4.5 - 2024-11-08

### What's Changed

* Add 'id' field to GetUserRequest by @dceleste35 in https://github.com/agicom/laravel-telemaque/pull/67

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.4...v1.4.5

## v1.4.4 - 2024-10-17

### What's Changed

* Add 'responsable_legal' field to GetAgencyRequest and AgencyDTO by @bnzo in https://github.com/agicom/laravel-telemaque/pull/66

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.3...v1.4.4

## v1.4.3 - 2024-09-05

### What's Changed

* chore: Update composer dependencies versions by @bnzo in https://github.com/agicom/laravel-telemaque/pull/65

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.2...v1.4.3

## v1.4.2 - 2024-09-05

### What's Changed

* Add 'gender' field to GetUserRequest by @bnzo in https://github.com/agicom/laravel-telemaque/pull/64

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.1...v1.4.2

## v1.3.9.1 - 2024-07-16

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.9...v1.3.9.1

## v1.4.1 - 2024-07-16

### What's Changed

* chore: Refactor GetUserRequest to use comma-separated fields in API response by @bnzo in https://github.com/agicom/laravel-telemaque/pull/63

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.4.0...v1.4.1

## v1.4.0 - 2024-07-10

### What's Changed

* Update illuminate/contracts dependency to support version 11.0 by @dceleste35 in https://github.com/agicom/laravel-telemaque/pull/59

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.9...v1.4.0

## v1.3.9 - 2024-06-26

### What's Changed

* chore: Add 'company_name', 'status', fields to GetUserRequest by @bnzo in https://github.com/agicom/laravel-telemaque/pull/57

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.8...v1.3.9

## v1.3.8 - 2024-05-16

### What's Changed

* chore: Update dependencies for GitHub workflows by @bnzo in https://github.com/agicom/laravel-telemaque/pull/56
* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/53
* Bump ramsey/composer-install from 2 to 3 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/50

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.7...v1.3.8

## v1.3.7 - 2024-05-15

### What's Changed

* Fix-agencies by @bnzo in https://github.com/agicom/laravel-telemaque/pull/55

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.6...v1.3.7

## v1.3.6 - 2024-03-07

### What's Changed

* Add siret field to GieDTO and update fixture files by @bnzo in https://github.com/agicom/laravel-telemaque/pull/51

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.5...v1.3.6

## v1.3.5 - 2024-02-22

### What's Changed

* Refactor AgencyDTO to use getCountryCode directly in defaults() method by @bnzo in https://github.com/agicom/laravel-telemaque/pull/48
* Add new fields to GetAgenciesRequest and GetAgencyRequest by @bnzo in https://github.com/agicom/laravel-telemaque/pull/49

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.4...v1.3.5

## v1.3.4 - 2024-02-19

### What's Changed

* Add tests for retrieving agencies by GIE and retrieving specific agency details by @bnzo in https://github.com/agicom/laravel-telemaque/pull/45
* Add GieStatus enum, GieResource class, GetGiesRequest and GieDTO classes, and JSON fixtures for user, agency, and agencies by @bnzo in https://github.com/agicom/laravel-telemaque/pull/46
* Add PermissionsCast and update UserDTO and GetAgencyTest by @bnzo in https://github.com/agicom/laravel-telemaque/pull/47

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.3.3...v1.3.4

## v1.1.6 - 2023-11-23

### What's Changed

- Paginate by @bnzo in https://github.com/agicom/laravel-telemaque/pull/23

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.5...v1.1.6

## v1.1.5 - 2023-11-20

### What's Changed

- Update package name in config file by @bnzo in https://github.com/agicom/laravel-telemaque/pull/22

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.4...v1.1.5

## v1.1.4 - 2023-11-17

### What's Changed

- Add Livewire wireable interface to AgencyDTO and by @bnzo in https://github.com/agicom/laravel-telemaque/pull/21

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.3...v1.1.4

## v1.1.3 - 2023-11-17

### What's Changed

- Update namespace and use statements by @bnzo in https://github.com/agicom/laravel-telemaque/pull/20

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.2...v1.1.3

## v1.1.2 - 2023-11-09

### What's Changed

- wip by @bnzo in https://github.com/agicom/laravel-telemaque/pull/18
- update to saloon v3 by @bnzo in https://github.com/agicom/laravel-telemaque/pull/19

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.1...v1.1.2

## v1.1.1 - 2023-10-11

### What's Changed

- Removed: Dates and Enum casting by @bnzo in https://github.com/agicom/laravel-telemaque/pull/17
- Bump stefanzweifel/git-auto-commit-action from 4 to 5 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/16

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.1.0...v1.1.1

## v1.1.0 - 2023-10-02

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.9...v1.1.0

## v1.0.9 - 2023-09-18

### What's Changed

- Bump actions/checkout from 3 to 4 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/14
- Added: New API calls by @bnzo in https://github.com/agicom/laravel-telemaque/pull/15

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.8...v1.0.9

## v1.0.8 - 2023-07-09

### What's Changed

- Wireable temp fix by @bnzo in https://github.com/agicom/laravel-telemaque/pull/13

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.7...v1.0.8

## v1.0.7 - 2023-07-05

### What's Changed

- Fix by @bnzo in https://github.com/agicom/laravel-telemaque/pull/12

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.6...v1.0.7

## v1.0.6 - 2023-07-05

### What's Changed

- Fileds added by @bnzo in https://github.com/agicom/laravel-telemaque/pull/11

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.5...v1.0.6

## v1.0.5 - 2023-07-05

### What's Changed

- Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/9
- Wireable by @bnzo in https://github.com/agicom/laravel-telemaque/pull/10

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.4...v1.0.5

## v1.0.4 - 2023-06-27

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.3...v1.0.4

## v1.0.3 - 2023-06-26

### What's Changed

- Changed: DTOs by @bnzo in https://github.com/agicom/laravel-telemaque/pull/7
- Added: Search agencies by GIE by @bnzo in https://github.com/agicom/laravel-telemaque/pull/8

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.2...v1.0.3

## v1.0.2 - 2023-06-22

### What's Changed

- Changed: Specify call by @bnzo in https://github.com/agicom/laravel-telemaque/pull/6

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v1.0.1...v1.0.2

## v1.0.1 - 2023-06-19

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v0.1.0...v1.0.1

## v0.1.0 - 2023-06-16

### What's Changed

- Added: New DTO implementation by @bnzo in https://github.com/agicom/laravel-telemaque/pull/5

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v0.0.3...v0.1.0

## v0.0.3 - 2023-06-13

### What's Changed

- Added: Agency can be null by @bnzo in https://github.com/agicom/laravel-telemaque/pull/3
- Added: Ability to find agency with a Sweepbright Office Id by @bnzo in https://github.com/agicom/laravel-telemaque/pull/4

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v0.0.2...v0.0.3

## v0.0.2 - 2023-06-02

### What's Changed

- Update: Logo size by @bnzo in https://github.com/agicom/laravel-telemaque/pull/2

### New Contributors

- @bnzo made their first contribution in https://github.com/agicom/laravel-telemaque/pull/2

**Full Changelog**: https://github.com/agicom/laravel-telemaque/compare/v0.0.1...v0.0.2

## v0.0.1 - 2023-06-02

### What's Changed

- First release!
- Bump aglipanci/laravel-pint-action from 2.2.0 to 2.3.0 by @dependabot in https://github.com/agicom/laravel-telemaque/pull/1

### New Contributors

- @dependabot made their first contribution in https://github.com/agicom/laravel-telemaque/pull/1

**Full Changelog**: https://github.com/agicom/laravel-telemaque/commits/v0.0.1
