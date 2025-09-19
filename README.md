# Netzkollektiv_EasyCreditOverwriteAddress

A lightweight Magento 2 module that augments the Netzkollektiv EasyCredit integration to support Click & Collect scenarios.

When the shipping method denotes in-store pickup (identified by the marker "[Selbstabholung]"), the module adjusts the EasyCredit transaction payload so the shipping address matches the billing address. This prevents address validation issues on EasyCredit's side for pickup orders when the merchants address is being set as shipping address.

## Requirements
- Magento Open Source or Adobe Commerce 2.4.x
- `netzkollektiv/module-easycredit` installed and enabled

## Installation

### With Composer (recommended)
1. Add the repository or path to your project if this is a local package.
2. Require the module package.
3. Enable the module and run setup upgrades.

Example for a path repository (place this folder under packages/ and adjust path):
```json
{
  "repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/netzkollektiv/m2-easycredit-click-and-collect-overwrite-address"
    }
  ]
}
```

Then install and enable:
```bash
composer require netzkollektiv/easycredit-click-and-collect-overwrite-address:dev-main
bin/magento module:enable Netzkollektiv_EasyCreditOverwriteAddress
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual copy (not recommended)
- Copy the module to `app/code/Netzkollektiv/EasyCreditOverwriteAddress`
- Run:
```bash
bin/magento module:enable Netzkollektiv_EasyCreditOverwriteAddress
bin/magento setup:upgrade
bin/magento cache:flush
```

## How it works
- A plugin on `Netzkollektiv\EasyCredit\BackendApi\QuoteBuilder::build()` runs after the transaction is built.
- If the EasyCredit customer relationship indicates a logistics service provider that contains `[Selbstabholung]` (Click & Collect / self pickup), the plugin copies the invoice address to the shipping address in the outgoing transaction.

## Configuration / Behavior
- No admin configuration is required.
- Detection is string-based on `[Selbstabholung]`. Ensure your pickup method includes this marker in the EasyCredit `logisticsServiceProvider` field.

## Support / Notes
- Intended as a companion to the official EasyCredit module.
- Test in a staging environment before production rollout.
- MIT License
