# Change Log for OXID eShop Community Edition Core Component

## v8.0.0 - unreleased

### Added
- New cache interfaces
- Shop pool service for easier management of shop based caching

### Changed
- Admin directory is not removed from the url in `ViewConfig::getModuleUrl` anymore [PR-817](https://github.com/OXID-eSales/oxideshop_ce/pull/817)
- Reset created product "sold" counter during Copying of the product [PR-913](https://github.com/OXID-eSales/oxideshop_ce/pull/913)
- `ModuleConfigurationValidatorInterface` is not optional anymore in the module activation service.
- The visibility of time-activated products has changed, products with an undefined end date appear in the shop for an unlimited period of time
- Replace module cache logic to a PSR based one and the related interface has also a simpler form
- Some services and commands use the new shop pool service and new cache related interfaces

### Removed
- Remove console classes from the Internal namespace: `Executor`, `ExecutorInterface`, `CommandsProvider`, `CommandsProviderInterface`
- Cleanup deprecated Private Sales Invite functionality
- `getContainer()` and `dispatchEvent()` methods from Core classes
- Remove deprecated global function \makeReadable()
- Redundant `TemplateFileResolverInterface` functionality
- Smarty templates support
- `PAYMENT_INFO_OFF` translation [#0006426](https://bugs.oxid-esales.com/view.php?id=6426) [PR-953](https://github.com/OXID-eSales/oxideshop_ce/pull/953)
- Obsolete module caching related services