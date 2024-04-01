<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        body {
            font-family: "Roboto", "DejaVu Sans", sans-serif;
            font-weight: 400;
            font-language-override: "CSY";
            font-style: normal;
        }
        .pad{
            padding-left: 5px;
            padding-right: 5px;
        }

        .page_break{
            page-break-after: always;
        }
      </style>
</head>
<body>
<div style="max-width:100%; max-height:100%;">
            <p>
              <!--Image in the corner-->
              <img
                width="135"
                height="63"
                src="{{url('/images/logo_text.png')}}"
                align="right"
                hspace="12"
              />
              <strong>LIST ROZHODČÍHO / THE BALLOT</strong>
            </p>
          </div>
          <!--Basic Info-->
          <div>
            <p>Turnaj / Tournament: {{ $ballot['Ballot']['tournament']['name'] }}</p>
            <p>
              Místo, datum / Place, date:
              {{
                $ballot['Ballot']['tournament']['institution']['name'] .
                ', ' .

                date("m.d.Y",strtotime($ballot['Ballot']['date']))
              }}.
            </p>
            <p>Rozhodčí / Adjudicator: </p>
            <p>Teze / Motion: {{ $ballot['Ballot']['motion']['name'] }}</p>
            <p>Tým af. / Team aff.: {{ $ballot['Ballot']['team_AFF']['name'] }}</p>
            <p>Tým neg. / Team neg.: {{ $ballot['Ballot']['team_NEG']['name'] }}</p>
          </div>
          <br clear="all" />
          <!--A Table-->
          <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
              <!--Table Header-->
              <tr>
                <td width="" rowspan="2" valign="top">
                  <p class='pad'>Jméno / Name:</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <p class='pad'>Poznámky k jednotlivci / Individual comments:</p>
                </td>
                <td width="" colspan="5" valign="top">
                  <p align="center">Řečnické body / Speaker points:</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p align="center">Obs. / Cont.</p>
                  <p align="center">20-40</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Str. / Str.</p>
                  <p align="center">15-30</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Styl / Style</p>
                  <p align="center">15-30</p>
                </td>
                <td width="" valign="top">
                  <p align="center">K. v. / C. q.</p>
                  <p align="center">-5-5</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Souč. / Sum</p>
                  <p align="center">50-100</p>
                </td>
              </tr>
              <tr>
                <!--Table body-->
                <td width="" valign="top">
                  <!--A1 name-->
                  <p class='pad'>{{ $A1['person_id']['name'] . ' ' . $A1['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--A1 comment-->
                  <p class='pad'>{{ $A1['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A1 content points-->
                  <p align="center">{{ $A1['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A1 strategy points-->
                  <p align="center">{{ $A1['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A1 style points-->
                  <p align="center">{{ $A1['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A1 cross questions points-->
                  <p align="center">{{ $A1['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A1 points sum-->
                  <p align="center">
                  {{ $A1['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>A1</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <!--A2 name-->
                  <p class='pad'>{{ $A2['person_id']['name'] . ' ' . $A2['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--A2 comment-->
                  <p class='pad'>{{ $A2['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A2 content points-->
                  <p align="center">{{ $A2['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A2 strategy points-->
                  <p align="center">{{ $A2['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A2 style points-->
                  <p align="center">{{ $A2['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A2 cross questions points-->
                  <p align="center">{{ $A2['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A2 points sum-->
                  <p align="center">
                  {{ $A2['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>A2</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <!--A3 name-->
                  <p class='pad'>{{ $A3['person_id']['name'] . ' ' . $A3['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--A3 comment-->
                  <p class='pad'>{{ $A3['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A3 content points-->
                  <p align="center">{{ $A3['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A3 strategy points-->
                  <p align="center">{{ $A3['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A3 style points-->
                  <p align="center">{{ $A3['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A3 cross questions points-->
                  <p align="center">{{ $A3['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--A3 points sum-->
                  <p align="center">
                  {{ $A3['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>A3</p>
                </td>
              </tr>
            </tbody>
          </table>

          <br />
          <div class="page_break" ></div>

          <!--N Table-->
          <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
              <!--Table Header-->
              <tr>
                <td width="" rowspan="2" valign="top">
                  <p class='pad'>Jméno / Name:</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <p class='pad'>Poznámky k jednotlivci / Individual comments:</p>
                </td>
                <td width="" colspan="5" valign="top">
                  <p align="center">Řečnické body / Speaker points:</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p align="center">Obs. / Cont.</p>
                  <p align="center">20-40</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Str. / Str.</p>
                  <p align="center">15-30</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Styl / Style</p>
                  <p align="center">15-30</p>
                </td>
                <td width="" valign="top">
                  <p align="center">K. v. / C. q.</p>
                  <p align="center">-5-5</p>
                </td>
                <td width="" valign="top">
                  <p align="center">Souč. / Sum</p>
                  <p align="center">50-100</p>
                </td>
              </tr>
              <tr>
                <!--Table Body-->
                <td width="" valign="top">
                  <!--N1 Name-->
                  <p class='pad'>{{ $N1['person_id']['name'] . ' ' . $N1['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--N1 comment-->
                  <p class='pad'>{{ $N1['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N1 content points-->
                  <p align="center">{{ $N1['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N1 strategy points-->
                  <p align="center">{{ $N1['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N1 style points-->
                  <p align="center">{{ $N1['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N1 cross questions points-->
                  <p align="center">{{ $N1['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N1 points sum-->
                  <p align="center">
                  {{ $N1['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>N1</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <!--N2 Name-->
                  <p class='pad'>{{ $N2['person_id']['name'] . ' ' . $N2['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--N2 comment-->
                  <p class='pad'>{{ $N2['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N2 content points-->
                  <p align="center">{{ $N2['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N2 strategy points-->
                  <p align="center">{{ $N2['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N2 style points-->
                  <p align="center">{{ $N2['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N2 cross questions points-->
                  <p align="center">{{ $N2['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N2 points sum-->
                  <p align="center">
                  {{ $N2['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>N2</p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <!--N3 Name-->
                  <p class='pad'>{{ $N3['person_id']['name'] . ' ' . $N3['person_id']['surname'] }}</p>
                </td>
                <td width="" rowspan="2" valign="top">
                  <!--N3 comment-->
                  <p class='pad'>{{ $N3['comment'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N3 content points-->
                  <p align="center">{{ $N3['cont_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N3 strategy points-->
                  <p align="center">{{ $N3['str_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N3 style points-->
                  <p align="center">{{ $N3['style_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N3 cross questions points-->
                  <p align="center">{{ $N3['cq_points'] }}</p>
                </td>
                <td width="" rowspan="2">
                  <!--N3 points sum-->
                  <p align="center">
                   {{ $N3['points_sum'] }}
                  </p>
                </td>
              </tr>
              <tr>
                <td width="" valign="top">
                  <p class='pad'>N3</p>
                </td>
              </tr>
            </tbody>
          </table>

              <br />
              <div class="page_break" ></div>

          <!--Decision table-->
          <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td width="" valign="top">
                  <div>
                    <p align="center" class='pad'>
                      Konkrétní a podrobné vysvětlení rozhodnutí / Concrete and
                      detailed justification of the decision:
                    </p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <table border="1" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td width="701px" valign="top">
                  <!--Decision-->
                  <p class='pad'>{{ $ballot['Ballot']['decision'] }}</p>
                </td>
              </tr>
            </tbody>
          </table>
          <!--More General Info-->
          <p>
            Rozhodčího vítězný tým / Adjudicator’s winning team:
            {{ $ballot['Ballot']['adj_winning_team']['name'] }}
          </p>
          <p>
            Vítězný tým / Winning team: {{ $ballot['Ballot']['winning_team']['name'] }}
          </p>
          <p>Rozhodnutím / Adjudications: {{ $ballot['Ballot']['adjucations'] }}</p>
          <p>
            Nejlepší řečník / Best speaker: {{ $best_speaker['role'] . ' - ' . $best_speaker['person_id']['name'] . ' ' . $best_speaker['person_id']['surname'] }}

          </p>
          <p>
            Součet řečnických bodů / Sum of speaker points: A: {{ $ballot['Ballot']['team_AFF']['points_sum'] }}
             N: {{ $ballot['Ballot']['team_NEG']['points_sum'] }}
          </p>
    </body>
</html>
