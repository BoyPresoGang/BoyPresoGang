# Week 10 Bug Triage

This document records confirmed Week 10 QA findings and their GitHub tracker status. No production code or test files were modified.

## GitHub Issue Audit

- Repository: `BoyPresoGang/BoyPresoGang`
- Three confirmed Week 10 findings were identified for tracker filing.
- No duplicate issue was found for these three confirmed findings.
- GitHub Issues were created for each confirmed bug.
- Issue numbers are recorded below.

---

## Confirmed Bugs

### Bug 1 — Customer Create gives no visible feedback for oversized contact input

- **GitHub Issue:** `#178`
- **Title:** `[P2] Customer Create provides no visible feedback for oversized contact numbers`
- **Severity:** P2
- **Feature:** Customer Create
- **QA Source:** Week 10 adversarial browser QA

#### Reproduction Steps

1. Open `/customers/create`.
2. Enter a valid customer name, such as `Huge Input QA`.
3. Enter a 30-digit contact number.
4. Submit the form.

#### Expected Behavior

The form should show a clear, human-readable validation message explaining that the contact number must contain exactly 11 digits.

#### Actual Behavior

The form remained on the Create Customer page with the entered value and no visible in-page validation or human-readable error. The invalid record was not created.

#### Evidence Limitation

The browser showed no application-level feedback. This report does not claim whether native browser validation or the API rejected the request internally.

---

### Bug 2 — Customer Create gives no useful visible feedback for empty required fields

- **GitHub Issue:** `#179`
- **Title:** `[P2] Customer Create gives no useful visible feedback for empty required fields`
- **Severity:** P2
- **Feature:** Customer Create
- **QA Source:** Week 10 adversarial browser QA

#### Reproduction Steps

1. Open `/customers/create`.
2. Leave Customer Name and Contact Number empty.
3. Submit the form.

#### Expected Behavior

The form should clearly identify both required fields and explain what the user must enter.

#### Actual Behavior

The page remained open and no useful application-level validation feedback was visible in the rendered UI.

#### Evidence Limitation

Native browser required-field validation may have blocked submission. The available browser accessibility output did not expose a useful validation message, so this should be confirmed with browser developer tools before implementation.

---

### Bug 3 — Order Create gives no visible feedback when quantity exceeds stock

- **GitHub Issue:** `180`
- **Title:** `[P1] Order Create does not show feedback when quantity exceeds available stock`
- **Severity:** P1
- **Feature:** Order Create
- **QA Source:** Week 10 manual QA and adversarial browser QA

#### Reproduction Steps

1. Open `/orders/create`.
2. Select the product `Ring of Regen`, which displayed available stock of `1`.
3. Enter quantity `2`.
4. Submit the form.

#### Expected Behavior

The form should display a clear quantity/stock validation message.

The backend contract is expected to reject the request with HTTP 422 and identify `quantity`, but that backend behavior was not executed in the unavailable-PHP QA environment.

#### Actual Behavior

The form remained on the Order Create page without a visible validation or error message. The manual QA did not observe a backend 422 response.

#### Evidence Limitation

Automated coverage was added for the expected backend 422 behavior, but PHP was unavailable and the test did not execute. This issue is therefore specifically based on the observed frontend feedback behavior; it does not claim that the backend validation is missing.

---

## Findings Intentionally Not Filed

### Product–Order Orphan State

The Order list displayed `Product unavailable` for an existing order. This matches the previously documented Product deletion flaw in `docs/find-the-flaw.md`.

It was not filed as a new issue to avoid creating a duplicate of the existing Week 9 finding.

### Legacy Deliveries Without an Associated Order

Delivery list/detail pages displayed `No associated order` and quantity `—` for legacy records.

This was not filed as a new bug because the available evidence does not establish that this behavior violates the current intended compatibility behavior.

### Untested Scenarios

No issues were created for scenarios marked `NOT TESTED`, including:

- Network failures
- Slow network conditions
- Valid double submissions
- Refresh during submission
- Acting on deleted records
- Permission failures
- Empty list states
- Concurrency
- Full stock mutation flows
- Full Delivery lifecycle flows

---

## Validation

- `git diff --check` was run after creating this document and produced no output.
- No production files were modified.
- No test files were modified.
- All three confirmed bugs were documented with reproduction steps, expected behavior, actual behavior, severity, and tracker issue references.
- Findings that were already documented, potentially intentional legacy behavior, or not actually tested were intentionally excluded from new bug reports.