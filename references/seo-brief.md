# All Connected Electric LLC: SEO input pack (GBP/NAP, services, keywords, competitors, site map)
**DataForSEO spend (Oct 21, 2026): ≈ $0.198.** GBP $0.0054 + 3 Maps SERPs $0.006 + 2 organic $0.007 + Hagerstown volumes $0.09 + Maryland volumes $0.09. Balance $19.793 → **$19.595**.

Premium website build (design.pageone.cloud). Build `428c4793…` (status: building, New Build, phase 7 failed), deal `125181cb…`, owner Andrew "Andy" Porter.
Checked read-only on Oct 21, 2026 with DataForSEO my_business_info (by place_id), Maps and organic SERPs, Google Ads volumes, read-only named-column SELECTs on website_builds/deals, and public web sources. Nothing was changed. Raw data: /workspace/seo/clients/all-connected-electric-dfs.json, all-connected-electric-crm.txt

## GBP (source of truth)
| Field | GBP value |
|---|---|
| Name | **All Connected Electric** (legal name in CRM/intake: All Connected Electric LLC) |
| Address | **19813 Leitersburg Pike Ste 301, Hagerstown, MD 21742** (shown; storefront listing). Pin 39.679318, -77.679471 |
| Service area | Not returned by DFS (verify in GBP manager). CRM intake: "Hagerstown" only |
| Phone | **(301) 704-6333** |
| Website | **None on the GBP** |
| Hours | **Mon–Fri 7:30 AM–5:00 PM · Sat 9:00 AM–1:00 PM · Sun closed** |
| Primary category | Electrician |
| Additional categories | **None** returned (verify in GBP manager) |
| GBP services | Not returned by DFS (verify in GBP manager) |
| Place ID | `ChIJ8fq1qxOTyYkR47kOuL3zo7E` |
| CID | `12800342562079422947` |
| Maps link | https://maps.google.com/maps?cid=12800342562079422947 |
| Review link | https://search.google.com/local/writereview?placeid=ChIJ8fq1qxOTyYkR47kOuL3zo7E |
| Rating | **4.8★, 17 reviews** |
| Photos | 37 · Claimed: yes · Description: none |

**Map embed:** `https://maps.google.com/maps?cid=12800342562079422947&output=embed` or Embed API `https://www.google.com/maps/embed/v1/place?key=<KEY>&q=place_id:ChIJ8fq1qxOTyYkR47kOuL3zo7E`. The CRM intake `gbp_map_embed` is empty.

## Mismatches
| Source | Name | Address | Phone | Hours |
|---|---|---|---|---|
| GBP | All Connected Electric | 19813 Leitersburg Pike Ste 301, Hagerstown 21742 | (301) 704-6333 | M–F 7:30–5, Sat 9–1 |
| CRM build intake | All Connected Electric LLC | same | same | **blank** (`hours` and `business_hours` empty) |
| CRM deal.working_hours | – | – | – | M–F 7:30–5, Sat 9–1 (manual, confirmedByClient=false; matches GBP) |
| Hagerstown licensed contractor list | All Connected Electric Llc | **768 Essex Circle, Greencastle, PA 17225** | 301-704-6333 | – |
Notes: intake `services: []` is empty (this is why phases 1–6 ran with no services list). The Greencastle PA address is a licensing/mailing address; keep it off the site. Use the GBP address.

## Site NAP to use
All Connected Electric · 19813 Leitersburg Pike Ste 301, Hagerstown, MD 21742 · (301) 704-6333 · Mon–Fri 7:30 AM–5 PM, Sat 9 AM–1 PM. Schema: Electrician/LocalBusiness with full PostalAddress, geo, `hasMap` = CID URL, openingHours as above, `areaServed`. No aggregateRating, no FAQPage schema, no llms.txt.

## License
- **Verified (city level):** City of Hagerstown "Contractors Online List – Electricians" (8/2026 edition, hagerstownmd.org/DocumentCenter/View/22942): **Master Electrician · All Connected Electric Llc · EM-1096 · expires 12/31/2026** (listed means registered/active with the city). The holder's individual name isn't on that list.
- **Not verified: Maryland State Board of Master Electricians license.** I couldn't confirm a state license number or status. The MD Labor online lookup wasn't checked successfully. **Don't put a state license number on the site** until it's confirmed. Safe to use now: "Hagerstown Master Electrician EM-1096" (confirm wording with client). BuildZoom says "license not required (2019)", which is stale and unreliable.

## Services (sources: GBP category, CRM description, public reviews)
- From CRM description: **commercial, residential, industrial, panel upgrades.**
- From reviews (BestProsInTown/Exa): **EV/wall charger installation**, breaker diagnosis & repair, **hot tub hookup** (Frederick, MD client since 2018), general electrical repair.
- GBP services list and secondary categories: unverified (see above).
- Existing site: **none** (no GBP website; intake web_sources is only the GBP share link). Yelp listing exists (yelp.com/biz/all-connected-electric-hagerstown).

## Current search position
- Map pack: **#11** for "electrician hagerstown md", **#7** for "panel upgrade hagerstown md", **not in the top 12** for "commercial electrician hagerstown md". The lack of a website is a likely factor; 17 reviews is competitive except vs Kline (887).
- Organic: only the Yelp listing shows (#22); no site of its own.

## Keywords (Google Ads, Oct 2026)
Hagerstown city-level volume is small; Maryland statewide volume shows **priority**.
| # | Keyword | Hagerstown /mo | MD /mo | CPC | Target page |
|---|---|---|---|---|---|
| 1 | electrician(s) hagerstown (md), one cluster | **50** each variant | 6,600 (electrician) | $16 | / |
| 2 | electrical contractor | <10 | 480 | $9 | / + /commercial-electrical/ |
| 3 | commercial electrician | <10 | 170 | $16 | /commercial-electrical/ |
| 4 | industrial electrician | <10 | 90 | $5 | /industrial-electrical/ |
| 5 | residential electrician | <10 | 210 | $16 | /residential-electrical/ |
| 6 | electrical panel replacement / panel upgrade / service upgrade | <10 | 110 / 20 / 10 | $3 | /panel-upgrades/ |
| 7 | ev charger installation | 10 | 320 | $20 | /ev-charger-installation/ |
| 8 | whole house generator / generator installation | <10 (cost: 10) | 720 / 90 | $7–18 | /generator-installation/ (if offered) |
| 9 | surge protection | <10 | 1,900 | $1 | section on /panel-upgrades/ |
| 10 | recessed / lighting installation / landscape lighting | <10 | 1,300 / 50 / 390 | $1–12 | /lighting-installation/ |
| 11 | ceiling fan installation | <10 | 210 | $9 | lighting page section |
| 12 | electrical repair / rewiring / wiring | <10 | 90 / 90 / 320 | $1–18 | /electrical-repair/ |
| 13 | emergency electrician | <10 | 170 | $23 | only if after-hours service is real |
| 14 | electrical inspection | <10 | 90 | $34 | section on /electrical-repair/ |
Nearby cities: "electrician frederick md", "martinsburg wv", "chambersburg pa", "waynesboro pa" = **10/mo each**; Smithsburg, Williamsport, Boonsboro, Maugansville, Halfway, Funkstown = 0. Brand "all connected electric (llc)" = 10.

## Competitors (Maps "electrician / panel upgrade / commercial electrician hagerstown md" + organic)
| Competitor | Pack / reviews | Notes |
|---|---|---|
| Kline Electrical Services (gokline.com) | #1–2 all · 5.0★ (887) | #2 organic; service pages (e.g. /services/home-electrical-safety-inspection) + call landing subdomain |
| Ellsworth Electric (ellsworthelectric.net) | #1–2 · 3.7★ (41) | #7 organic, home page |
| MEC, Inc. (mec-electrical.com) | #3–5 · 5.0★ (27) | #12 organic, commercial focus |
| Shifler Electrical Associates | #3–8 · 4.3★ (13) | |
| ALC Weaver Electric | #4–9 · 4.3★ (7) | ranks with a Facebook page (#9 organic) |
| Larry & Sons (larryandsons.com) | #6/#11 · 4.8★ (5,339) | multi-trade; /electrical/wiring/ ranks #9 |
| Kolb Electric (kolbelectric.com) | #4 · 2.3★ (3) | templated /service-area/hagerstown-md/ |
| Williams Elec, CDJ Electric | organic only | commercial-electrician-hagerstown-md pages |
**Takeaway:** a weak pack (several leaders with <50 reviews or <4.5★). A real website linked from the GBP plus dedicated service pages should be enough to move into the top 3 quickly. Hagerstown's own permit/licensed-contractor pages also rank, so the license is a trust signal worth showing.

## Recommended site map (premium build)
- **/** Home: Electrician in Hagerstown, MD
- **/services/** hub, then dedicated pages:
  - /residential-electrical/
  - /commercial-electrical/
  - /industrial-electrical/ (confirm scope)
  - /panel-upgrades/ (panel replacement, service upgrades, breaker repair, surge protection)
  - /ev-charger-installation/ (proven in reviews, highest local volume)
  - /electrical-repair/ (troubleshooting, rewiring, inspections)
  - /lighting-installation/ (recessed, fixtures, ceiling fans, landscape)
  - /hot-tub-pool-wiring/ (from reviews; confirm)
  - /generator-installation/ (only if offered)
- **Areas:** one **/areas-we-serve/** page with the map and a town list (Hagerstown, Frederick, Smithsburg, Williamsport, Boonsboro, Greencastle/Waynesboro PA, Martinsburg WV, as he confirms). **No templated city pages**; add a town page only where there are real jobs and photos (Frederick is the likely first).
- /about/ (Andy Porter, since 2016, license), /reviews/, /projects/ (37 GBP photos, EV charger job), /contact/ (GBP map embed), /faqs/ (content only, no FAQ schema), /blog/
- **Redirects:** none needed; there's no existing site. If the client has an old domain, map it at launch.

## Titles / H1s (no "near me")
| Page | Title | H1 |
|---|---|---|
| Home | Electrician in Hagerstown, MD \| All Connected Electric | Hagerstown Electrician for Homes & Businesses |
| Residential | Residential Electrician in Hagerstown, MD \| All Connected | Residential Electrical Services in Hagerstown |
| Commercial | Commercial Electrician in Hagerstown, MD \| All Connected | Commercial Electrical Contractor in Hagerstown |
| Industrial | Industrial Electrical Services \| Hagerstown, MD | Industrial Electrical Work |
| Panels | Electrical Panel Upgrades in Hagerstown, MD | Panel Upgrades & Replacement |
| EV | EV Charger Installation in Hagerstown, MD \| All Connected | Home EV Charger Installation |
| Repair | Electrical Repair & Troubleshooting \| Hagerstown, MD | Electrical Repair & Troubleshooting |
| Lighting | Lighting & Ceiling Fan Installation \| Hagerstown, MD | Lighting Installation |

## Open questions (client / Calvin)
1. Full services list: confirm industrial scope, generators, hot tub/pool wiring, EV brands, emergency/after-hours.
2. Maryland State Board of Master Electricians license number and status (also PA/WV licenses if he works there). Is EM-1096 the number he wants shown?
3. Service area and towns he really works in (GBP service area and secondary categories weren't visible via API; check the GBP manager).
4. Confirm the hours (GBP M–F 7:30–5, Sat 9–1) and fill the empty intake hours.
5. Any existing or old domain to redirect? Which domain should be used for the new site, and link it on the GBP at launch.
6. Add a GBP description and secondary categories (e.g. Electrical installation service), plus a review-request flow.
7. Job photos and stories for the projects page and a Frederick page.
