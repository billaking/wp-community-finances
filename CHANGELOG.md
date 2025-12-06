# Changelog

All notable changes to BK Finances will be documented in this file.

## [1.3.0] - 2025-12-06

### Changed
- **BREAKING:** Renamed all prefixes from `WCF_`, `wcf_` to `BK_FIN_`, `bk_fin_`
- **BREAKING:** Class names updated: `WP_Community_Finances` → `BK_Finances`
- **BREAKING:** Text domain changed to `bk-finances`
- **BREAKING:** CSS classes updated from `.wcf-` to `.bk-fin-`
- **BREAKING:** JavaScript variables updated to use `bkFin` prefix
- Updated dependency check to look for `BK_Community_Core` class
- Changed dependency check to warning instead of fatal error (allows activation)

### Fixed
- Corrected dependency check function names (was using wrong plugin prefix)
- Fixed plugin name in error messages
- Plugin now activates successfully even if Core plugin is not installed (shows warning)

## [1.2.0] - 2025-12-06

### Added
- Enhanced financial reporting
- Group-based financial tracking
- Modern UI/UX improvements

## [1.1.0] - 2025-12-06

### Added
- Initial release with financial management features
- Budget tracking
- Expense management
- Financial reports
- Integration with accounting system
