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

  Scenario: Suzanne hears Bobbie who is nearby
    Given
    When
    Then

  Scenario: Suzanne doesn't hear Freddie who is far away
    Given "Suzanne" is at "St John's College"
    But "Freddie" is at "Trafalgar Square"
    When Freddie shouts
    Then Suzanne doesn't hear the message

  @manual
  Scenario: Oh I dunno...
