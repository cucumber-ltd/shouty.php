Feature: Hear shout

  Rules:
  - Must be within 1 km
  - Displayed in order of creation
  - Network and geo location must be enabled

  Notes:
  - Display error when no geo or network

  Assumption:
  - Everybody has geo location and network

  Questions:
  - Should people hear their own messages?

  Background:
    Given the following locations:
      | name                   | lat       | lon      |
      | the Norwich Castle     | 52.682729 | 1.296386 |
      | Washington DC          | 38.8951   | -77.0367 |
      | the Bell Hotel Norwich | 52.6725   | 1.29517  |

  Scenario: Phil can't hear Jeff who is far away
    Given Jeff is in the Norwich Castle
    And Phil is in Washington DC
    When Jeff shouts
    Then Phil should not hear anything

  Scenario: Phil can hear Sally who is within range
    Given Sally is in the Norwich Castle
    And Phil is in the Bell Hotel Norwich
    When Sally shouts "You around Phil?"
    Then Phil should hear "You around Phil?"

  Scenario: Phil hears Jeff's shout after Sally's shout
    Given Phil is around
    When Sally shouts "one"
    And Jeff shouts "two"
    Then Phil should hear:
      | message |
      | one     |
      | two     |
