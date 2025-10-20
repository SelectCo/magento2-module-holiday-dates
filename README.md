# SelectCo Holiday Dates

Magento 2 module that stores and exposes a list of public/bank holiday dates for use in checkout, shipping lead‑time calculations, and other business logic.

It provides:
- Admin configuration for the source API and locale (country/sub‑country)
- Storage of holiday dates in a dedicated entity
- CLI commands to fetch/update and purge stored dates
- Helper methods to retrieve configured values and the list of dates for application code
- Admin UI (grid/form) to review/manage dates

## Requirements
- Magento 2 (tested with 2.3.5)
- PHP compatible with your Magento version
- Composer dependency: select-co/module-core ^1.0.2

## Installation
You can install this module either via Composer or by placing it in app/code.

### Composer (preferred)
1. Require the package:
   - `composer require select-co/module-holiday-dates`
2. Enable and set up the module:
   - `bin/magento module:enable SelectCo_HolidayDates`
   - `bin/magento setup:upgrade`
   - In production mode: `bin/magento setup:di:compile` and `bin/magento setup:static-content:deploy -f`

### Manual installation (app/code)
1. Copy this directory to `app/code/SelectCo/HolidayDates`.
2. Run:
   - `bin/magento module:enable SelectCo_HolidayDates`
   - `bin/magento setup:upgrade`
   - In production mode: `bin/magento setup:di:compile` and `bin/magento setup:static-content:deploy -f`

## Configuration
Admin Path: Stores > Configuration > SelectCo > Holiday Dates

Fields:
- Enabled (selectco_hd/general/enabled)
- API Base Url (selectco_hd/general/api_url)
- Warehouse Country Code, e.g. GB, US, AU (selectco_hd/general/country_code)
- Warehouse Sub Country Code, e.g. ENG, NSW (selectco_hd/general/sub_country_code)
- Years In Advance to fetch (selectco_hd/general/years)
- Months History to keep (selectco_hd/general/months_history)

Save config, then run the update command to fetch dates.

## CLI Commands
- Update dates from the configured API:
  - `bin/magento holidaydates:update`
- Purge stored dates (according to retention rules):
  - `bin/magento holidaydates:purge`

You may schedule these commands with cron as needed.

## Programmatic Usage
Inject the helper SelectCo\HolidayDates\Helper\Data where needed.

Example (PHP):
```
public function __construct(\SelectCo\HolidayDates\Helper\Data $helper)
{
    $this->holidayHelper = $helper;
}

if ($this->holidayHelper->isModuleEnabled()) {
    $dates = $this->holidayHelper->getHolidayDates(); // ["2025-12-25", "2025-12-26", ...]
    $apiUrl = $this->holidayHelper->getApiUrl();
    $country = $this->holidayHelper->getCountryCode();
    $region = $this->holidayHelper->getSubCountryCode();
}
```

getHolidayDates() returns an array of date strings (Y-m-d) from the stored entity repository.

## Troubleshooting
- Ensure configuration is set and the module is Enabled
- Run `bin/magento holidaydates:update` after changing API/locale config
- Check Magento system and exception logs for errors during updates
- Verify SelectCo Core module is installed and enabled

## License
Proprietary. See composer.json.

## Support
If you have a feature request or spotted a bug or a technical problem, create a GitHub issue.