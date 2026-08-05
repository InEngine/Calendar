# Session handoff (Calendar)

Use this file so new chats pick up **recent package work**, **branch focus**, and **next steps**. Add newest sessions **at the top** (below `<!-- SESSION_LOG_START -->`). Do not store secrets.

**Repo:** https://github.com/InEngine/Calendar — Composer **`inengine/calendar`**. Path checkout: `InEngine/Modules/Calendar`. Consumed by LTC (and **`inengine/calendar-google-adapter`**) via Packagist tag or **`composer.local.json`** path/`@dev`.

**Role:** base calendar domain — provider contracts, DTOs, selected calendars, event queries/cache for widgets and other host features. Keep Google API details out of this package.

---

## Idea sketch (two-package split — agreed 2026-08-05)

Issue **#143** (LTC home widgets) is two problems: an **app-facing calendar domain**, and **how you fetch**. Split mirrors TableUI-style packaging: host talks to one API; providers plug in.

| Package | Owns |
|--------|------|
| **`inengine/calendar`** (this package) | Contracts (`CalendarProvider`, maybe `ReadsEvents` / `ListsCalendars`), DTOs (`Event`, `TimeRange`, `CalendarRef`), config for selected calendars, cache/query facade. Optional presentation primitives later — leave My LTC widgets in the host until UI settles. |
| **`inengine/calendar-google-adapter`** (**Calendar adapter**) | Implements the provider against Google Calendar API; auth (service account / domain-wide or OAuth as chosen); maps Google payloads → DTOs; owns `google/apiclient` (or similar). Folder/repo spelling: **Calender-Google-Adapter**. Informal name in conversation: **Calendar adapter**. |

**This package (core):** selection model (“these calendar IDs are school-wide upcoming / meals / schedule”), normalize timezones, merge/sort events from multiple sources, cache keys, rate-limit-friendly `eventsBetween($calendars, $from, $to)` + short TTL for v1, authorization hooks. Tests bind a **fake provider** without Google.

**Adapter:** auth, calendar list sync, incremental sync / etags later, Google-specific errors, webhook/push later if needed.

**LTC app:** home widgets, layout per role, which feed maps to which widget. Do not put My LTC Blade here on day one.

**Caveats:** don’t invent a huge sync engine first; school shared calendars ≠ user OAuth (decide auth early); class schedule “later personalized” may be SIS/enrollment — core must allow a non-Google provider for that feed. Composer **`suggest`** points hosts at the Google adapter; hosts that need Google require it explicitly.

**#143 practical plan:** ship both; Google as only provider initially; LTC widgets as first consumer; core stays provider- and widget-agnostic.

---

## How to update

1. Paste a new block **below** `<!-- SESSION_LOG_START -->`.
2. Mention branch, issue/PR links (LTC **#143**), and any host bump / path-repo notes.

<!-- SESSION_LOG_START -->

### 2026-08-05 — Cursor rules + githooks from TableUI pattern

- **Status:** Added **`.githooks`** (same as TableUI) and Cursor **`.cursor/rules`** (attribution, session handoff, PHP standards, issue assignee, `.DS_Store`, package conventions). Google sibling informal name: **Calendar adapter**.
- **Next:** design provider contracts + event DTOs; fake provider for tests; then Calendar adapter + LTC widgets.

### 2026-08-05 — Idea sketch recorded; Google adapter suggested

- **Status:** Scaffold still in place; architecture sketch pasted into this handoff (and sibling adapter handoff) for later implementation.
- **Composer:** **`suggest.inengine/calendar-google-adapter`** added so hosts discover the Google provider without a hard require.
- **Next:** design provider contracts + event DTOs; fake provider for tests; then adapter + LTC widgets.

### 2026-08-05 — Scaffold wired for LTC #143

- **Status:** **In progress** with LTC **`issue-143-calendar-widgets`**.
- **Package:** Spatie Laravel skeleton configured as **`inengine/calendar`** / namespace **`InEngine\Calendar`** (PHP **`^8.5`**). Still mostly skeleton (`Calendar` facade/provider) — domain contracts not built yet.
- **Sibling:** Google provider lives in **`InEngine/Modules/Calender-Google-Adapter`** (note folder/repo spelling **Calender**) → Composer **`inengine/calendar-google-adapter`**.
- **Host (LTC):** path/`@dev` via gitignored **`composer.local.json`**; PHPStorm content roots + VCS mapping added on the LTC app module.
- **Next:** design provider contracts + event DTOs; wire fake provider for tests; then Google adapter implementation for school calendars (upcoming / meals / schedule feeds).

