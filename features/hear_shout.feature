Feature: Hear shout

  If someone shouts something, anyone nearby
  can hear that shout as long as they're within
  1km of the shouter.

  Rules:
  - Shout range is 1km
  - Geo location must be on
  - Network must be on

  Questions:
  - Do hears shouts disappear when we move away?
  - Do people need an account to shout? Or to listen?
  - How much precision do we need for distance?
  - Should people hear their own messages?

  Scenario: Suzanne does not hear herself
    When "Suzanne" shouts
    Then "Suzanne" doesn't hear anything

  Scenario: Suzanne hears Bobbie who is nearby
    Given "Suzanne" is at "St John's College"
    But "Bobbie" is at "Balliol College"
    When "Bobbie" shouts
    Then "Suzanne" hears the shout

  Scenario: Suzanne doesn't hear Freddie who is far away
    Given "Suzanne" is at "St John's College"
    But "Freddie" is at "Trafalgar Square"
    When "Freddie" shouts
    Then "Suzanne" doesn't hear anything

  @manual
  Scenario: Oh I dunno...
