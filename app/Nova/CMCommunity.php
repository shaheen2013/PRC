<?php

namespace App\Nova;

use Carbon\Carbon;
use Eminiarts\Tabs\Tabs;
use Inspheric\Fields\Url;
use App\Models\OptInStatus;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Prochamps\BulkId\BulkId;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Eminiarts\Tabs\TabsOnEdit;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Models\OnboardingStatus;
use Laravel\Nova\Fields\HasMany;
use App\Models\RelationshipStatus;
use Davidpiesse\NovaToggle\Toggle;
use Dniccum\PhoneNumber\PhoneNumber;
use App\Models\ViolationConfiguration;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Actions\ExportCommunities;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Prochamps\RentalMapField\RentalMapField;
use Prochamps\CommunityFilter\CommunityFilter;
use Saumini\EllipsisTextarea\EllipsisTextarea;
use Prochamps\CommunitySummary\CommunitySummary;
use Prochamps\CommunityListDashboard\CommunityListDashboard;

class CMCommunity extends Resource
{
    use TabsOnEdit;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    //  use SortRelations;

    public static $model = \App\Models\CMCommunity::class;


    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'contacts', 'crmForeclosureSale', 'housingData', 'foreclosureStats', 'communityLogo',
        'configuration', 'salesConfiguration', 'miscConfiguration', 'rentalVacantSalesStatus',
        'state', 'contracts', 'relationshipManagers', 'salesCycles',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = '';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'FRIENDLYNAME';


    /**
     * Get the search result subtitle for the resource.
     *
     * @return string|null
     */
    public function subtitle()
    {
        return "{$this->COMMUNITYID} - {$this->COUNTY} County, {$this->STATE}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'FRIENDLYNAME',
        'STATE',
    ];


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Communities';
    }


    /**
     * Determine if this resource is searchable.
     *
     * @return bool
     */
    public static function searchable()
    {
        return false;
    }

    public static function relatableModifications(NovaRequest $request, $query)
    {
        return $query->where('active', 1);
    }


    //  Due to limitations in Nova, this index query was needed to support sorting of related attributes
    public static function indexQuery(NovaRequest $request, $query)
    {
        $resourceTable = 'osusr_mlv_community';
        $query->select("{$resourceTable}.*");
        $orderBy = $request->get('orderBy');

        if ($orderBy == 'STATE') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('STATE', $request->get('orderByDirection'));
            $query->orderBy('u.housing_units', 'desc');
        } elseif ($orderBy == 'ID') {
            $query->getQuery()->orders = null;
            $query->orderBy('ID', $request->get('orderByDirection'));
        } elseif ($orderBy == 'FRIENDLYNAME') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('FRIENDLYNAME', $request->get('orderByDirection'));
            $query->orderBy('u.housing_units', 'desc');
        } elseif ($orderBy == 'Foreclosure_Sales_Status') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('u.quartile', $request->get('orderByDirection'));
            $query->orderBy('u.housing_units', 'desc');
        } elseif ($orderBy == 'Housing_Units') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('u.housing_units', $request->get('orderByDirection'));
        } elseif ($orderBy == 'est_long_term_rental') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('u.est_long_term_rental', $request->get('orderByDirection'));
        } elseif ($orderBy == 'est_vacant_total') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->getQuery()->orders = null;
            $query->orderBy('u.est_vacant_total', $request->get('orderByDirection'));
        } elseif ($orderBy == 'active_foreclosures') {
            $query->leftJoin('OSUSR_tvl_RTStatsSummaryHistory as f', "{$resourceTable}.COMMUNITYID", '=',
                'f.COMMCOMMUNITYID')
                ->where('ISMOSTCURRENT', 1);
            $query->getQuery()->orders = null;
            $query->orderBy('f.FORECLOSURESACTIVE', $request->get('orderByDirection'));
        } elseif ($orderBy == 'ORDER') {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->join('cm_community_rm as r', "{$resourceTable}.COMMUNITYID", '=', 'r.community_id')->first();
            $query->getQuery()->orders = null;
            $query->orderBy('r.relationship_manager_id', $request->get('orderByDirection'));
            $query->orderBy('u.housing_units', 'desc');
        } else {
            $query->leftJoin('cm_community_quartiles as u', "{$resourceTable}.COMMUNITYID", '=', 'u.community_id');
            $query->when(empty($request->get('orderBy')), function (Builder $q) {
                $q->getQuery()->orders = null;

                return $q->orderBy('u.housing_units', 'desc');
            });
        }
        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            ID::make('Id', 'COMMUNITYID')->sortable()->onlyOnIndex(),

            EllipsisTextarea::make('Community', 'FRIENDLYNAME')
                ->sortable()->onlyOnIndex()->displayLength(20)->resolveUsing(function ($name) {
                    if ($this->miscConfiguration) {
                        if ($this->miscConfiguration->custom_friendly_name) {
                            return $this->miscConfiguration->custom_friendly_name;
                        } else {
                            return $name;
                        }
                    } else {
                        return $name;
                    }
                }),
            
            Text::make('PU', 'salesCycles')->onlyOnIndex()->resolveUsing(function ($salesCycles, $model) {
                $cycles = $model->salesCycles()->where('community_id', $this->COMMUNITYID)->get();
                return $cycles->count();
            }),

            EllipsisTextarea::make('RM', 'ORDER')->resolveUsing(function () {
                return data_get($this->relationshipManagers->get('0'), 'name', '');
            })->sortable()->displayLength(10)->alwaysShow()->onlyOnIndex(),

            Text::make('Size', 'Foreclosure_Sales_Status')->resolveUsing(function () {
                return $this->Foreclosure_Sales_Status;
            })->sortable()->onlyOnIndex(),

            Number::make('Housing', 'Housing_Units')->resolveUsing(function () {
                return number_format(floatval($this->Housing_Units));
            })->sortable()->onlyOnIndex(),

            /*(new Tabs('Tasks/Projects', [
                'Tasks' => [
                    Text::make(' ', function () {
                        return 'T';
                    }),
                ],
                'Tasks2' => [
                    Text::make(' ', function () {
                        return ' ';
                    }),
                ],
            ]))->withToolbar(),*/

            (new Tabs('At-Risk Property Analysis', [
                'Rental' => [
                    Text::make('Rental', 'est_long_term_rental')->resolveUsing(function () {
                        $estRental = number_format(floatval($this->est_long_term_rental));
                        if ($this->salesCycles->count() > 0) {
                            $activeRentalSalesCycle = $this->salesCycles->where('rental', true)->where('active',
                                true)->first();
                            if ($activeRentalSalesCycle) {
                                $rentalSalesStatus = (int) $activeRentalSalesCycle->sales_stage;
                            } else {
                                $rentalSalesStatus = 0;
                            }
                        } else {
                            $rentalSalesStatus = 0;
                        }
                        if ($this->rental_partner_status) {
                            if ($rentalSalesStatus == 0) {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&nbsp;</span>&nbsp; {$estRental}";
                            } else {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&#43;&nbsp;</span>&nbsp; {$estRental}";
                            }
                        } else {
                            if ($rentalSalesStatus == 0) {
                                return "<span class='border border-black'>&nbsp;0 </span>&nbsp; {$estRental}";
                            } else {
                                return "<span style='background-color:gold;'>&nbsp;".(new \App\Models\CMCommunity())->convertSalesStatusId($rentalSalesStatus)."&nbsp;</span>&nbsp; {$estRental}";
                            }
                        }
                    })->sortable()->onlyOnIndex()->asHtml(),
                    Number::make('Estimated Long Term Rentals', function () {
                        return number_format(floatval($this->est_long_term_rental));
                    })->sortable()->onlyOnDetail(),
                    RentalMapField::make('Rental Density Map')->program('rental'),
                ],
                'Vacant' => [
                    Text::make('Vacant', 'est_vacant_total')->resolveUsing(function () {
                        $estVacant = number_format(floatval($this->est_vacant_total));
                        if ($this->salesCycles->count() > 0) {
                            $activeVacantSalesCycle = $this->salesCycles->where('vacant', true)->where('active',
                                true)->first();
                            if ($activeVacantSalesCycle) {
                                $vacantSalesStatus = (int) $activeVacantSalesCycle->sales_stage;
                            } else {
                                $vacantSalesStatus = 0;
                            }
                        } else {
                            $vacantSalesStatus = 0;
                        }
                        if ($this->vacant_partner_status) {
                            if ($vacantSalesStatus == 0) {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&nbsp;</span>&nbsp; {$estVacant}";
                            } else {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&#43;&nbsp;</span>&nbsp; {$estVacant}";
                            }
                        } else {
                            if ($vacantSalesStatus == 0) {
                                return "<span class='border border-black'>&nbsp;0 </span>&nbsp; {$estVacant}";
                            } else {
                                return "<span style='background-color:gold;'>&nbsp;".(new \App\Models\CMCommunity())->convertSalesStatusId($vacantSalesStatus)."&nbsp;</span>&nbsp; {$estVacant}";
                            }
                        }
                    })->sortable()->onlyOnIndex()->asHtml(),
                    Number::make('Estimated Vacant - Total', function () {
                        return number_format(floatval($this->est_vacant_total));
                    })->sortable()->onlyOnDetail(),
                    Number::make('Estimated Vacant - Rental', function () {
                        return number_format(floatval($this->est_vacant_rental));
                    })->sortable()->onlyOnDetail(),
                    Number::make('Estimated Vacant - For Sale', function () {
                        return number_format(floatval($this->est_vacant_for_sale));
                    })->sortable()->onlyOnDetail(),
                    Number::make('Estimated Vacant - Seasonal', function () {
                        return number_format(floatval($this->est_vacant_seasonal));
                    })->sortable()->onlyOnDetail(),
                    Number::make('Estimated Vacant - Other', function () {
                        return number_format(floatval($this->est_vacant_long_term));
                    })->sortable()->onlyOnDetail(),
                    RentalMapField::make('Vacant Density Map')
                        ->program('vacant'),
                ],
                'Foreclosure' => [
                    Text::make('Foreclosure', 'active_foreclosures')->resolveUsing(function () {
                        $estForeclosure = number_format($this->foreclosureStats->where('ISMOSTCURRENT', 1)->first() ?
                            $this->foreclosureStats->where('ISMOSTCURRENT', 1)->first()->FORECLOSURESACTIVE : null);
                        if ($this->salesCycles->count() > 0) {
                            $activeForeclosureSalesCycle = $this->salesCycles->where('foreclosure', true)->where('active',
                                true)->first();
                            if ($activeForeclosureSalesCycle) {
                                $foreclosureSalesStatus = (int) $activeForeclosureSalesCycle->sales_stage;
                            } else {
                                $foreclosureSalesStatus = 0;
                            }
                        } else {
                            $foreclosureSalesStatus = 0;
                        }
                        if ($this->foreclosure_partner_status) {
                            if ($foreclosureSalesStatus == 0) {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&nbsp;</span>&nbsp; {$estForeclosure}";
                            } else {
                                return "<span style='background-color:green;color:white'>&nbsp;&#10004;&#43;&nbsp;</span>&nbsp; {$estForeclosure}";
                            }
                        } else {
                            if ($foreclosureSalesStatus == 0) {
                                return "<span class='border border-black'>&nbsp;0 </span>&nbsp; {$estForeclosure}";
                            } else {
                                return "<span style='background-color:gold;'>&nbsp;".(new \App\Models\CMCommunity())->convertSalesStatusId($foreclosureSalesStatus)."&nbsp;</span>&nbsp; {$estForeclosure}";
                            }
                        }
                    })->sortable()->onlyOnIndex()->asHtml(),
                    Number::make('Foreclosures', function () {
                        return number_format($this->foreclosureStats->where('ISMOSTCURRENT', 1)->first() ?
                            $this->foreclosureStats->where('ISMOSTCURRENT', 1)->first()->FORECLOSURESACTIVE : null);
                    })->sortable()->onlyOnDetail(),
                    RentalMapField::make('Foreclosure Map')->program('foreclosure'),
                ],
            ])),

            (new Tabs('Community Configurations', [
                'Sales' => [
                    Text::make('Program Status', function () {
                        switch ($this->Rental_Sales_Status) {
                            case 1:
                                $rentalStatus = 'No Activity';

                                break;
                            case 5:
                                $rentalStatus = "<span style='color: green'>&#10004;</span>";

                                break;
                            case 6:
                                $rentalStatus = 'Onboard';

                                break;
                            case 7:
                                $rentalStatus = 'Generate';

                                break;
                            case 10:
                                $rentalStatus = 'No Interest';

                                break;
                            case 11:
                                $rentalStatus = 'Guide';

                                break;
                            case 12:
                                $rentalStatus = 'Propose';

                                break;
                            case 13:
                                $rentalStatus = 'Generate';

                                break;
                            case 14:
                                $rentalStatus = 'Upgrade';

                                break;
                            default:
                                $rentalStatus = 'Unknown';

                                break;
                        }
                        switch ($this->Vacant_Sales_Status) {
                            case 1:
                                $vacantStatus = 'No Activity';

                                break;
                            case 5:
                                $vacantStatus = "<span style='color: green'>&#10004;</span>";

                                break;
                            case 6:
                                $vacantStatus = 'Onboard';

                                break;
                            case 7:
                                $vacantStatus = 'Generate';

                                break;
                            case 10:
                                $vacantStatus = 'No Interest';

                                break;
                            case 11:
                                $vacantStatus = 'Guide';

                                break;
                            case 12:
                                $vacantStatus = 'Propose';

                                break;
                            case 13:
                                $vacantStatus = 'Generate';

                                break;
                            case 14:
                                $vacantStatus = 'Upgrade';

                                break;
                            default:
                                $vacantStatus = 'Unknown';

                                break;
                        }
                        switch ($this->Sales_Status_Id) {
                            case 1:
                                $foreclosureStatus = 'No Activity';

                                break;
                            case 5:
                                $foreclosureStatus = "<span style='color: green'>&#10004;</span>";

                                break;
                            case 6:
                                $foreclosureStatus = 'Onboard';

                                break;
                            case 7:
                                $foreclosureStatus = 'Generate';

                                break;
                            case 10:
                                $foreclosureStatus = 'No Interest';

                                break;
                            case 11:
                                $foreclosureStatus = 'Guide';

                                break;
                            case 12:
                                $foreclosureStatus = 'Propose';

                                break;
                            case 13:
                                $foreclosureStatus = 'Generate';

                                break;
                            case 14:
                                $foreclosureStatus = 'Generate';

                                break;
                            default:
                                $foreclosureStatus = 'Unknown';

                                break;
                        }
                        return "<b>Rental:</b> {$rentalStatus}  |  <b>Vacant:</b> {$vacantStatus}  |  <b>Foreclosure:</b> {$foreclosureStatus}";
                    })->asHtml()->onlyOnForms(),

                    Toggle::make('Rental Partner Status', 'rentalVacantSalesStatus.rental_partner_status')
                        ->fillUsing(function ($request, $model) {
                            $model->rentalVacantSalesStatus()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'rental_partner_status' => $request->rentalVacantSalesStatus_rental_partner_status,
                            ]);
                        })->onlyOnForms(),

                    Toggle::make('Vacant Partner Status', 'rentalVacantSalesStatus.vacant_partner_status')
                        ->fillUsing(function ($request, $model) {
                            $model->rentalVacantSalesStatus()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'vacant_partner_status' => $request->rentalVacantSalesStatus_vacant_partner_status,
                            ]);
                        })->onlyOnForms(),

                    Toggle::make('Foreclosure Partner Status', 'rentalVacantSalesStatus.foreclosure_partner_status')
                        ->fillUsing(function ($request, $model) {
                            $model->rentalVacantSalesStatus()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'foreclosure_partner_status' => $request->rentalVacantSalesStatus_foreclosure_partner_status,
                            ]);
                        })->onlyOnForms(),

                    Toggle::make('Remittance Email Required', 'salesConfiguration.remittance_email_required')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'remittance_email_required' => $request->salesConfiguration_remittance_email_required,
                            ]);
                        })->onlyOnForms(),

                    Text::make('Relationship Status', function () {
                        if ($this->Relationship_Status === null) {
                            return $this->Relationship_Status;
                        } else {
                            return "<span style='color: {$this->Relationship_Status}'>&#11044;</span>";
                        }
                    })->onlyOnForms()->asHtml(),
                    Select::make('Relationship Status', 'salesConfiguration.relationship_status')
                        ->options((new RelationshipStatus())->allOptions())
                        ->displayUsingLabels()
                        ->onlyOnForms()
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'relationship_status' => $request->salesConfiguration_relationship_status,
                            ]);
                        }),
                    Text::make('Relationship Status Notes', 'salesConfiguration.relationship_status_notes')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'relationship_status_notes' => $request->salesConfiguration_relationship_status_notes,
                            ]);
                        })->onlyOnForms(),
                    Select::make('Opt-in Status', 'salesConfiguration.opt_in_status')
                        ->options((new OptInStatus())->allOptions())
                        ->displayUsingLabels()
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'opt_in_status' => $request->salesConfiguration_opt_in_status,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('RFP Activity', 'salesConfiguration.rfp_status')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'rfp_status' => $request->salesConfiguration_rfp_status,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('Key Policy Agreement', 'salesConfiguration.key_policy_agreement')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'key_policy_agreement' => $request->salesConfiguration_key_policy_agreement,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('Special Oversight', 'salesConfiguration.special_oversight')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'special_oversight' => $request->salesConfiguration_special_oversight,
                            ]);
                        })->onlyOnForms(),
                    Text::make('Special Oversight Notes', 'salesConfiguration.special_oversight_notes')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'special_oversight_notes' => $request->salesConfiguration_special_oversight_notes,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('Strong Mayor', 'salesConfiguration.strong_mayor')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'strong_mayor' => $request->salesConfiguration_strong_mayor,
                            ]);
                        })->onlyOnForms(),
                    Text::make('Mayor Notes', 'salesConfiguration.mayor_notes')
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'mayor_notes' => $request->salesConfiguration_mayor_notes,
                            ]);
                        })->onlyOnForms(),
                    Select::make('Onboarding Status', 'salesConfiguration.onboarding_status')
                        ->options((new OnboardingStatus())->allOptions())
                        ->displayUsingLabels()
                        ->fillUsing(function ($request, $model) {
                            $model->salesConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'onboarding_status' => $request->salesConfiguration_onboarding_status,
                            ]);
                        })->onlyOnForms(),
                ],
                'Branding' => [
                    Email::make('Group Email', 'GROUPEMAIL')->onlyOnForms(),
                    Image::make('Logo')->disk('s3')->onlyOnForms(),
                    Url::make('Community Redirect Url', 'configuration.redirect_url')
                        ->hideFromIndex()->clickable()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'redirect_url' => $request->configuration_redirect_url,
                            ]);
                        })->onlyOnForms(),
                    Email::make('Compliance Redirect Email', 'configuration.redirect_email')
                        ->hideFromIndex()->rules('url')->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'redirect_email' => $request->configuration_redirect_email,
                            ]);
                        })->onlyOnForms(),
                    PhoneNumber::make('Community Redirect Phone Number', 'configuration.redirect_phone')
                        ->country('US')->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'redirect_phone' => $request->configuration_redirect_phone,
                            ]);
                        })->onlyOnForms()->disableValidation(),
                    Text::make('Compliance Warning Phone Number Extension', 'configuration.redirect_phone_ext')
                        ->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'redirect_phone_ext' => $request->configuration_redirect_phone_ext,
                            ]);
                        })->onlyOnForms(),
                    Url::make('Community Page Url - Rental', 'configuration.community_page_rental_url')
                        ->hideFromIndex()->clickable()->rules('url')->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'community_page_rental_url' => $request->configuration_community_page_rental_url,
                            ]);
                        })->onlyOnForms(),
                    Url::make('Community Page Url - Vacant', 'configuration.community_page_vacant_url')
                        ->hideFromIndex()->clickable()->rules('url')->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'community_page_vacant_url' => $request->configuration_community_page_vacant_url,
                            ]);
                        })->onlyOnForms(),
                    Url::make('Community Page Url - Foreclosure', 'configuration.community_page_foreclosure_url')
                        ->hideFromIndex()->clickable()->rules('url')->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'community_page_foreclosure_url' => $request->configuration_community_page_foreclosure_url,
                            ]);
                        })->onlyOnForms(),
                    Trix::make('Landing Page Content', 'configuration.landing_page_content')
                        ->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'landing_page_content' => $request->configuration_landing_page_content,
                            ]);
                        })->onlyOnForms(),
                    Trix::make('Program Page Content - Rental', 'configuration.program_page_content_rental')
                        ->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'program_page_content_rental' => $request->configuration_program_page_content_rental,
                            ]);
                        })->onlyOnForms(),
                    Trix::make('Program Page Content - Vacant', 'configuration.program_page_content_vacant')
                        ->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'program_page_content_vacant' => $request->configuration_program_page_content_vacant,
                            ]);
                        })->onlyOnForms(),
                    Trix::make('Program Page Content - Foreclosure', 'configuration.program_page_content_foreclosure')
                        ->hideFromIndex()->fillUsing(function ($request, $model) {
                            $model->configuration()->updateOrCreate(['community_id' => $model->COMMUNITYID], [
                                'program_page_content_foreclosure' => $request->configuration_program_page_content_foreclosure,
                            ]);
                        })->onlyOnForms(),
                ],
                'Misc' => [
                    Text::make('Custom Community Name', 'miscConfiguration.custom_friendly_name')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'custom_friendly_name' => $request->miscConfiguration_custom_friendly_name,
                            ]);
                        })->onlyOnForms()->withMeta(['extraAttributes' => [
                            'placeholder' => $this->FRIENDLYNAME, ],
                        ]),
                    Text::make('Custom Data Field 1', 'FIELD1')->onlyOnForms()->nullable()->readonly()->nullValues(['', '0', 'null']),
                    Text::make('Custom Data Field 2', 'FIELD2')->onlyOnForms()->nullable()->readonly()->nullValues(['', '0', 'null']),
                    Text::make('Custom Data Field 3', 'FIELD3')->onlyOnForms()->nullable()->readonly()->nullValues(['', '0', 'null']),
                    Text::make('Custom Data Field 4', 'FIELD4')->onlyOnForms()->nullable()->readonly()->nullValues(['', '0', 'null']),
                    Text::make('Custom Data Field 5', 'FIELD5')->onlyOnForms()->nullable()->readonly()->nullValues(['', '0', 'null']),
                    Select::make('Violation Config', 'miscConfiguration.violation_configuration')
                        ->options((new ViolationConfiguration())->allOptions())
                        ->displayUsingLabels()
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'violation_configuration' => $request->miscConfiguration_violation_configuration,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('Utility Data', 'miscConfiguration.utility_data')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'utility_data' => $request->miscConfiguration_utility_data,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('CM Registrations - Rental', 'miscConfiguration.cm_registrations_rental')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'cm_registrations_rental' => $request->miscConfiguration_cm_registrations_rental,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('CM Registrations - Vacant', 'miscConfiguration.cm_registrations_vacant')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'cm_registrations_vacant' => $request->miscConfiguration_cm_registrations_vacant,
                            ]);
                        })->onlyOnForms(),
                    Toggle::make('CM Registrations - Foreclosure', 'miscConfiguration.cm_registrations_foreclosure')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'cm_registrations_foreclosure' => $request->miscConfiguration_cm_registrations_foreclosure,
                            ]);
                        })->onlyOnForms(),
                    Text::make('PostCard Project Name', 'miscConfiguration.postcard_project_name')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'postcard_project_name' => $request->miscConfiguration_postcard_project_name,
                            ]);
                        })->onlyOnForms(),
                    Text::make('PostCard Document Name', 'miscConfiguration.postcard_document_name')
                        ->fillUsing(function ($request, $model) {
                            $model->miscConfiguration()->updateOrCreate(['community_id' => $this->COMMUNITYID], [
                                'postcard_document_name' => $request->miscConfiguration_postcard_document_name,
                            ]);
                        })->onlyOnForms(),
                ],

            ]))->withToolbar()->defaultSearch(true),
            (new Tabs('Community Information', [
                'Interactions' => [
                    HasMany::make('Interactions', 'interactions', Interaction::class),
                ],
                'RMs' => [
                    BelongsToMany::make('RMs', 'relationshipManagers', RelationshipManager::class),
                ],
                'Contracts' => [
                    HasMany::make('Contracts'),
                ],
                'Remittance' => [
                    HasMany::make('Remittance', 'remittanceconfigs', Remittance::class),
                ],
                'People' => [
                    HasMany::make('People', 'contacts', Contact::class),
                ],
                'Change Requests' => [
                    HasMany::make('Change Requests', 'pendingModifications', Modifications::class),
                ],
                'Activity Log' => [
                    HasMany::make('Activity Log', 'activityLogs', ActivityLog::class),
                ],
                'Sales Cycles' => [
                    HasMany::make('Sales Cycles', 'salesCycles', SalesCycle::class),
                ],
            ]))->defaultSearch(true),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new CommunitySummary())->onlyOnDetail(),
            new CommunityListDashboard(),
            new CommunityFilter(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\CommunityRentalSalesStatus(),
            new Filters\CommunityVacantSalesStatus(),
            new Filters\CommunityForeclosureSalesStatus(),
            new Filters\CommunitySize(),
            new Filters\CommunityState(),
            new Filters\CommunityCounty(),
            new Filters\RelationshipManager(),
            new Filters\CommunityOrFilter(),
            new BulkId(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
//            new Lenses\ForeclosureContractExpiration(),
            new Lenses\BrandingConfiguration(),
            new Lenses\CommunityActivity(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ExportCommunities())
                ->withChunkCount(200)
                ->withFilename('Community_List-'.Carbon::now()->format('YmdHs').'.xlsx')
                ->withHeadings('Id', 'Community', 'State', 'County', 'RM', 'Secondary RM', 'Size', 'Housing Units',
                    'Rental Status', 'Rental Units', 'Vacant Status', 'Vacant Units', 'Foreclosure Status',
                    'Foreclose Units')
                ->onlyOnIndex(),
        ];
    }
}
