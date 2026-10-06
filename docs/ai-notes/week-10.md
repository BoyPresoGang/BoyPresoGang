# Week 10 — AI Notes

## AI Usage Summary

AI use was enabled for the Week 10 Manual QA & Bug Hunting lab, primarily for permitted test scaffolding, QA planning support, documentation structure, and review suggestions. The team designed and executed the QA process, made the final pass/fail decisions, and reviewed AI-assisted output before recording results.

Exact historical prompt text was not preserved for every activity. The prompt entries below are concise reconstructed work summaries based on repository artifacts and commit history, not verbatim quotations.

## Week 10 Task Contributions

1. **Task 1 — Build the test matrix:** Angel Mark S. Cabalgada. Repository evidence includes `f7cc9f2` (`docs: add Week 10 QA test matrix`) updating `docs/test-matrix.md`.
2. **Task 2 — Run manual QA passes:** Rommel John M. Agolito performed the manual QA work. The Git/GitHub contribution was attributed to Mark because Rommel used the wrong Gmail/Git identity; the repository author attribution must not be treated as proof that Mark performed the manual QA. The results were recorded in `docs/test-matrix.md`.
3. **Task 3 — Expand automated coverage:** Jerfrans D. Guerbo. Repository evidence includes `5d4523b` (`test: expand Week 10 automated coverage`).
4. **Task 4 — Adversarial QA / Break the app:** Abdul Cedick K. Kalaw. Repository evidence includes `5837dd5` (`docs: record Week 10 adversarial QA`).
5. **Task 5 — Log and triage bugs:** Christian Jay Lord Alsa Pedere. Repository evidence includes `22a3c84` (`docs: record Week 10 bug triage`).

## AI Prompt Log

### Task 1 — Test matrix

- **Purpose:** Structure the Week 10 manual QA matrix.
- **Prompt / reconstructed prompt:** “Review the implemented Customers, Products, Orders, and Deliveries features and organize a manual QA matrix with Happy, Boundary, Invalid, Empty, and Permissions scenarios, including cross-feature stock and delivery/order flows.”
- **What AI was asked to help with:** Identify user-facing features, API/CRUD paths, authorization flows, and important cross-feature scenarios.
- **How the output was used:** As a planning structure for `docs/test-matrix.md`.
- **Human verification/decision:** The team reviewed the implementation and decided which scenarios were relevant; no result was marked without actual QA evidence.

The exact original prompt was not preserved; this is a reconstructed summary from the matrix content and the Week 10 task allocation.

### Task 2 — Manual QA passes

- **Purpose:** Execute the Week 10 manual QA matrix against the running application and record observed results.
- **Prompt / reconstructed prompt:** “Help organize the remaining Week 10 manual QA scenarios and provide a checklist for recording only actually observed PASS/FAIL/NOT TESTED results. Do not invent results or modify application code.”
- **What AI was asked to help with:** Organize the QA checklist and documentation structure for the manual testing session.
- **How the output was used:** As guidance for organizing the manual QA session and recording results in `docs/test-matrix.md`.
- **Human verification/decision:** Rommel performed the manual QA himself. He executed the scenarios in the running application and determined the PASS, FAIL, and NOT TESTED results from actual observations.

The Git/GitHub attribution for the resulting matrix documentation shows Mark because Rommel used the wrong Gmail/Git identity. This attribution does not change the actual Task 2 performer.

### Task 3 — Automated test scaffolding

- **Purpose:** Expand automated coverage for critical Week 10 paths.
- **Prompt / reconstructed prompt:** “Inspect the existing Laravel feature tests, identify high-value uncovered validation and relationship cases, and add focused tests without changing production code or claiming unavailable test results as passing.”
- **What AI was asked to help with:** Select focused tests and follow the existing `RefreshDatabase` and feature-test conventions.
- **How the output was used:** Test additions were made in `tests/Feature/ProductTest.php`, `tests/Feature/OrderTest.php`, and `tests/Feature/DeliveryTest.php`.
- **Human verification/decision:** Jerfrans reviewed the test isolation and assertions. The added coverage included product price validation, over-stock order rejection, past delivery dates, and duplicate active deliveries.

PHP was unavailable in the working environment during the test work, so the Laravel test suite was not reported as successfully executed.

### Task 4 — Adversarial QA / Break the app

- **Purpose:** Exercise unexpected input and failure paths to find defects.
- **Prompt / reconstructed prompt:** “Run safe adversarial checks for huge inputs, Unicode and harmless XSS-style values, empty fields, navigation, duplicate actions, nonexistent IDs, stale records, and network failures; record only observed results and do not fix bugs.”
- **What AI was asked to help with:** Organize adversarial scenarios, identify safe test boundaries, and record evidence and limitations.
- **How the output was used:** As QA-session guidance and documentation support for `docs/adversarial-qa.md`.
- **Human verification/decision:** Abdul performed the browser checks and recorded the observed failures and untested scenarios. The team did not claim that AI discovered the bugs independently.

### Task 5 — Bug triage

- **Purpose:** Convert confirmed Week 10 QA findings into structured bug reports.
- **Prompt / reconstructed prompt:** “Review the QA matrix and adversarial QA evidence, avoid duplicates, and document confirmed bugs with titles, reproduction steps, expected behavior, actual behavior, severity, limitations, and tracker references.”
- **What AI was asked to help with:** Organize triage information and distinguish confirmed findings from untested or intentionally unfiled observations.
- **How the output was used:** As documentation support for `docs/bug-triage.md` and the Week 10 tracker entries.
- **Human verification/decision:** Christian reviewed the QA evidence, assigned the documented P1/P2 classifications using the handout criteria, and excluded untested or potentially intentional observations.

## AI-Assisted Test Scaffolding

The verified Week 10 automated-test work is the Jerfrans-authored commit `5d4523b`. It added focused feature-test coverage for:

- Non-positive Product price validation.
- Order quantity greater than available Product stock.
- Delivery dates in the past.
- Duplicate active Deliveries for one Order.

The tests use the existing Laravel feature-test style and controlled model fixtures. PHP was unavailable during the work, so the tests were not reported as executed successfully.

## Manual QA / Test Matrix Assistance

AI assistance supported the planning and organization of `docs/test-matrix.md`, but it did not perform the manual QA itself. Rommel performed Task 2, despite the Git/GitHub attribution appearing under Mark’s identity. The team made the actual PASS, FAIL, and NOT TESTED decisions based on browser observations and previously documented evidence.

## Adversarial QA Assistance

AI assistance supported scenario selection, safe-input planning, and documentation structure for `docs/adversarial-qa.md`. Abdul performed the adversarial browser checks. The documented findings included missing visible feedback for oversized Customer contact input, empty Customer submission, and Order over-stock input. No claim is made that AI independently discovered those defects.

## Bug Triage Assistance

AI assistance supported organizing the confirmed QA findings into `docs/bug-triage.md` and the corresponding tracker records. The repository documents:

- Issue #178: oversized Customer contact feedback, P2.
- Issue #179: empty Customer required-field feedback, P2.
- Issue #180: Order over-stock feedback, P1.

The Product–Order orphan state and legacy deliveries without an associated Order were intentionally not filed as new Week 10 bugs because the existing documentation treated them as an earlier finding or potentially intentional legacy behavior.

## AI Usage Boundaries

- AI assisted with test scaffolding, QA suggestions, prompt/work summaries, and documentation structure.
- The team designed and executed the QA process.
- Manual QA results were determined by the team from actual observations.
- Bugs were reviewed and verified by team members before being recorded.
- AI-generated suggestions were reviewed by team members before use.
- No fabricated test results should be presented as real results.
- PHP-unavailable test runs are documented as unavailable, not as passing.

This log is based on the actual Week 10 repository work, QA artifacts, commits, and existing bug documentation. It does not claim to reproduce exact historical prompts where those prompts were not preserved.
