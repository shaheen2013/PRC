<template>
    <loading-card :loading="!loaded">
        <card class="pb-2">
            <div class="flex flex-wrap items-center justify-center py-8">
                <div class="flex flex-wrap items-center justify-center w-1/2">
                    <div class="w-4/5 programContainer mb-2">
                        <div class="text-white bg-black pl-4 py-4 pr-4 text-center programText">
                            <h6>PROGRAM</h6>
                        </div>
                    </div>
                    <div class="line-break"></div>
                    <div :class="[programActive.rental ? activeProgramClass : inactiveProgramClass]"
                         @click="setRentalActive"
                    >
                        <img src="https://s3.amazonaws.com/communitymanagement/Rental.png" height="35px" alt="">
                        <h4>Rental Registration</h4>
                    </div>
                    <div :class="[programActive.vacant ? activeProgramClass : inactiveProgramClass]"
                         @click="setVacantActive"
                    >
                        <img src="https://s3.amazonaws.com/communitymanagement/Vacant.png" height="35px" alt="">
                        <h4>Vacant Registration</h4>
                    </div>
                    <div :class="[programActive.foreclosure ? activeProgramClass : inactiveProgramClass]"
                         @click="setForeclosureActive"
                    >
                        <img src="https://s3.amazonaws.com/communitymanagement/Foreclosure.png" height="35px" alt="">
                        <h4>Foreclosure Registration</h4>
                    </div>
                </div>

                <div class="flex items-center justify-center w-1/2 flex-wrap">
                    <div class="w-4/5 programContainer mb-2">
                        <div class="text-white bg-black pl-4 py-4 pr-4 text-center programText">
                            <h6>COUNT</h6>
                        </div>
                    </div>
                    <div class="line-break"></div>
                    <div :class="[countActive.household ? activeCountClass : inactiveCountClass]"
                         @click="setHouseholdActive"
                    >
                        <h2>Housholds</h2>
                    </div>
                    <div :class="[countActive.otr ? activeCountClass : inactiveCountClass]"
                         @click="setOtrActive"
                    >
                        <h2>OTRs</h2>
                    </div>
                    <div :class="[countActive.community ? activeCountClass : inactiveCountClass]"
                         @click="setCommunityActive"
                    >
                        <h2>Communities</h2>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="w-4/5 programContainer mb-2">
                    <div class="text-white bg-black pl-4 py-4 pr-4 text-center programText">
                        <h6>RESULTS</h6>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center flex-wrap mb-8">
                <div class="flex flex-wrap items-center justify-center w-full">
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.noActivity }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'noActivity']"
                    >
                        <h2 class="mt-4">No Actvity</h2>
                        <h4>0</h4>
                        <br>
                        <h1>
                            <animated-number
                                :value="displayed.noActivity"
                                :formatValue="formatNumber"
                                :duration="resultsAnimationDuration"
                                :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Opportunity</h5>
                    </router-link>
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.generate }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'generate']"
                    >
                        <h2 class="mt-4">Generate</h2>
                        <h4>1</h4>
                        <br>
                        <h1>
                            <animated-number
                                    :value="displayed.generate"
                                    :formatValue="formatNumber"
                                    :duration="resultsAnimationDuration"
                                    :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Lead</h5>
                    </router-link>
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.guide }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'guide']"
                    >
                        <h2 class="mt-4">Guide</h2>
                        <h4>2</h4>
                        <br>
                        <h1>
                            <animated-number
                                    :value="displayed.guide"
                                    :formatValue="formatNumber"
                                    :duration="resultsAnimationDuration"
                                    :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Prospect</h5>
                    </router-link>
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.propose }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'propose']"
                    >
                        <h2 class="mt-4">Propose</h2>
                        <h4>3</h4>
                        <br>
                        <h1>
                            <animated-number
                                    :value="displayed.propose"
                                    :formatValue="formatNumber"
                                    :duration="resultsAnimationDuration"
                                    :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Prospect</h5>
                    </router-link>
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.onboard }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'onboard']"
                    >
                        <h2 class="mt-4">Onboard</h2>
                        <h4>4</h4>
                        <br>
                        <h1>
                            <animated-number
                                    :value="displayed.onboard"
                                    :formatValue="formatNumber"
                                    :duration="resultsAnimationDuration"
                                    :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Partner</h5>
                    </router-link>
                    <router-link :to="{ path: 'resources/c-m-communities', query: { 'c-m-communities_filter': routerLinks.enhance }}"
                                 tag="div"
                                 :class="[resultsBaseClass, 'enhance']"
                    >
                        <h2 class="mt-4">Enhance</h2>
                        <h4>5</h4>
                        <br>
                        <h1>
                            <animated-number
                                    :value="displayed.enhance"
                                    :formatValue="formatNumber"
                                    :duration="resultsAnimationDuration"
                                    :round="true"
                            />
                        </h1>
                        <h5 class="mt-6">Partner</h5>
                    </router-link>
                </div>
            </div>
        </card>
    </loading-card>
</template>

<script>
import AnimatedNumber from "animated-number-vue";
export default {
    props: ['card',],
    components: {
        AnimatedNumber
    },
    computed: {
        loaded: function () {
            return this.loadedCount === 3;
        },
        displayed: function () {
            if (this[this.activeProgram][this.activeCount]) {
                return this[this.activeProgram][this.activeCount];
            } else {
                return {
                    noActivity: 0,
                    generate: 0,
                    guide: 0,
                    propose: 0,
                    onboard: 0,
                    enhance: 0,
                    upgrade: 0
                }
            }
        },
        routerLinks: function () {
            return {
                noActivity: Buffer.from(this.filterLinks[this.activeProgram].noActivity, 'binary').toString('base64'),
                generate: Buffer.from(this.filterLinks[this.activeProgram].generate, 'binary').toString('base64'),
                guide: Buffer.from(this.filterLinks[this.activeProgram].guide, 'binary').toString('base64'),
                propose: Buffer.from(this.filterLinks[this.activeProgram].propose, 'binary').toString('base64'),
                onboard: Buffer.from(this.filterLinks[this.activeProgram].onboard, 'binary').toString('base64'),
                enhance: Buffer.from(this.filterLinks[this.activeProgram].enhance, 'binary').toString('base64'),
                upgrade: Buffer.from(this.filterLinks[this.activeProgram].enhance, 'binary').toString('base64'),
            }
        }
    },
    data: () => ({
        resultsAnimationDuration: 700,
        activeProgram: 'rental',
        activeCount: 'community',
        programActive: {
            rental: true,
            vacant: false,
            foreclosure: false
        },
        countActive: {
            household: true,
            otr: false,
            community: false
        },
        activeProgramClass: "w-1/4 active text-center px-4 py-2 m-2 cursor-pointer boxClass shadow-lg content-center items-center justify-center boxSize",
        inactiveProgramClass: "w-1/4 text-grey-darker text-center px-4 py-2 m-2 cursor-pointer boxClass content-center items-center justify-center hoverShadow boxSize",
        activeCountClass: "flex w-1/4 active text-center px-4 py-2 m-2 cursor-pointer boxClass shadow-lg content-center items-center justify-center boxSize",
        inactiveCountClass: "flex w-1/4 text-grey-darker text-center px-4 py-2 m-2 cursor-pointer boxClass content-center items-center justify-center hoverShadow boxSize",
        resultsBaseClass: "text-grey-darker text-center px-4 py-2 m-2 content-center boxClass cursor-pointer hoverShadow boxSize",
        filterLinks: {
            rental: {
                noActivity: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":true,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":,\"14\":falsefalse}}]",
                generate: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":true,\"11\":false,\"12\":false,\"14\":false}}]",
                guide: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":true,\"12\":false,\"14\":false}}]",
                propose: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":true,\"14\":false}}]",
                onboard: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":true,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                enhance: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":true,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                upgrade: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityRentalSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":true}}]",
            },
            vacant: {
                noActivity: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":true,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                generate: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":true,\"11\":false,\"12\":false,\"14\":false}}]",
                guide: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":true,\"12\":false,\"14\":false}}]",
                propose: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":true,\"14\":false}}]",
                onboard: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":true,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                enhance: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":true,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                upgrade: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityVacantSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":true}}]",

            },
            foreclosure: {
                noActivity: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":true,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                generate: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":true,\"11\":false,\"12\":false,\"14\":false}}]",
                guide: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":true,\"12\":false,\"14\":false}}]",
                propose: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":true,\"14\":false}}]",
                onboard: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":true,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                enhance: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":true,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":false}}]",
                upgrade: "[{\"class\":\"App\\\\Nova\\\\Filters\\\\CommunityForeclosureSalesStatus\",\"value\":{\"1\":false,\"5\":false,\"6\":false,\"7\":false,\"11\":false,\"12\":false,\"14\":true}}]",
            }
        },
        rental: {
            cms: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            otrs: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            households: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            }
        },
        foreclosure: {
            cms: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            otrs: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            households: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            }
        },
        vacant: {
            cms: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            otrs: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            },
            households: {
                noActivity: 0,
                generate: 0,
                guide: 0,
                propose: 0,
                onboard: 0,
                enhance: 0,
                upgrade: 0
            }
        },
        loadedCount: 0
    }),
    methods: {
        formatNumber: function (value) {
            let si = [
                { value: 1, symbol: "" },
                { value: 1E3, symbol: "K" },
                { value: 1E6, symbol: "M" },
            ];
            let rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            let i;
            for (i = si.length - 1; i > 0; i--) {
                if (value >= si[i].value) {
                    break;
                }
            }
            return (value / si[i].value).toFixed(1).replace(rx, "$1") + si[i].symbol;
        },
        setRentalActive() {
            this.programActive.rental = true;
            this.programActive.vacant = false;
            this.programActive.foreclosure = false;
            this.activeProgram = 'rental'
        },
        setVacantActive() {
            this.programActive.rental = false;
            this.programActive.vacant = true;
            this.programActive.foreclosure = false;
            this.activeProgram = 'vacant'
        },
        setForeclosureActive() {
            this.programActive.rental = false;
            this.programActive.vacant = false;
            this.programActive.foreclosure = true;
            this.activeProgram = 'foreclosure'
        },
        setHouseholdActive() {
            this.countActive.household = true;
            this.countActive.otr = false;
            this.countActive.community = false;
            this.activeCount = 'households'
        },
        setOtrActive() {
            this.countActive.household = false;
            this.countActive.otr = true;
            this.countActive.community = false;
            this.activeCount = 'otrs'
        },
        setCommunityActive() {
            this.countActive.household = false;
            this.countActive.otr = false;
            this.countActive.community = true;
            this.activeCount = 'cms'
        },
        loadRental() {
            Nova.request().get('/nova-vendor/community-dashboard/rental').then(response => {
                this.rental = response.data;
                this.loadedCount++;
            });
        },
        loadVacant() {
            Nova.request().get('/nova-vendor/community-dashboard/vacant').then(response => {
                this.vacant = response.data;
                this.loadedCount++;
            });
        },
        loadForeclosure() {
            Nova.request().get('/nova-vendor/community-dashboard/foreclosure').then(response => {
                this.foreclosure = response.data;
                this.loadedCount++;
            });
        }
    },
    mounted() {
        this.setRentalActive();
        this.setHouseholdActive();
        this.loadRental();
        this.loadVacant();
        this.loadForeclosure();
    },
}
</script>

<style scoped>
    .programText {
        width: 100px;
    }
    .boxSize{
        height: 200px;
        width: 200px;
    }

    .line-break {
        width: 100%;
    }
    .programContainer {
        border-top: 4px solid #22292f;
    }
    .countContainer {
        border-top: 4px solid #7F888F;
    }
    .active {
        background-color: #DDEAFE;
    }
    .generate {
        background-color: #FCFBEB;

    }
    .guide {
        background-color: #FFF9C2;

    }
    .propose {
        background-color: #FFF382;

    }
    .onboard {
        background-color: #FFED4A;

    }
    .enhance {
        background-color: #F2D024;
    }
    .upgrade {
        background-color: #F2D024;
    }
    .boxClass {
        border: 1px solid #7F888F;
        border-radius: 5px;
        height: 200px;
    }
    .hoverShadow:hover {
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, .11), 0 5px 15px 0 rgba(0, 0, 0, .08);
    }
    .hoverShadow:focus {
        box-shadow: 0 0 0 0;
    }
</style>
