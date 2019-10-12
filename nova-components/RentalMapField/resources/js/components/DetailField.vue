<template>
    <panel-item :field="field">
        <template slot="value">
            <div v-if="!mapClicked" class="text-center">Click Map to enable scroll wheel zooming</div>
            <!--<button class="btn" @click="changeToVacant">Change to Vacant</button>-->
            <div v-if="program === 'rental'" @click="enableMap('rental')" id="rental-map" class="pr-2 map"></div>
            <div v-if="program === 'vacant'" @click="enableMap('vacant')" id="vacant-map" class="pr-2 map"></div>
            <div v-if="program === 'foreclosure'" @click="enableMap('foreclosure')" id="foreclosure-map" class="pr-2 map"></div>
            <button class="mapboxgl-ctrl-icon" aria-label="Center Map On Community" type="button"></button>
        </template>
    </panel-item>
</template>

<script>
    import mapboxgl from 'mapbox-gl';
    import { arcgisToGeoJSON } from '@esri/arcgis-to-geojson-utils';
    import turfExtent from 'turf-extent';
    import '@mapbox/mapbox-gl-geocoder/lib/mapbox-gl-geocoder.css';
    import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder'

    class AddButton {
        onAdd(map) {
            this._map = map;
            this._btn = document.createElement("button");
            this._btn.className = "mapboxgl-ctrl-icon mapboxgl-ctrl-back";
            this._btn.type = "button";
            this._btn["aria-label"] = "Reset Map";
            this._btn.onclick = function() {
                map.fitBounds(window.mapExtent, {padding: 20});
            };
            this._container = document.createElement('div');
            this._container.className = "mapboxgl-ctrl mapboxgl-ctrl-group";
            this._container.appendChild(this._btn);
            return this._container;
        }
        onRemove() {
            this._container.parentNode.removeChild(this._container);
            this._map = undefined;
        }
    }
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
        methods: {
            enableMap(program) {
                if (!this.mapClicked) {
                    map[program].scrollZoom.enable();
                    map[program].addControl(new MapboxGeocoder({
                        accessToken: mapboxgl.accessToken
                    }));
                    map[program].addControl(new mapboxgl.NavigationControl());
                    map[program].addControl(new mapboxgl.FullscreenControl());
                    map[program].addControl(new AddButton());
                }
                this.mapClicked = true;
            },
            bound() {
                console.log(this.bBox);

                map.fitBounds(this.bBox, {padding: 20}).bind(this);
            }
        },
        data: () => ({
            geoJson: null,
            rawbBox: null,
            bBox: null,
            mapClicked: false,
            program: null,
        }),
        created() {
            window.map = {};
            window.communityId = this.resourceId;
            if (this.field.hasOwnProperty('program')) {
                this.program = this.field.program;
            }
            mapboxgl.accessToken = 'pk.eyJ1IjoiYXN0YW1tIiwiYSI6ImNqcndhZjRwMjBhbnEzeXA5bjdiOTFibDMifQ.jWDAYxxH4ZqCnt4ZkihzHw';
            axios.get('https://maps.prochamps.com/agsserver/rest/services/FPRC/USJurisdictionalBoundsCRM/MapServer/2/query?where=CommCommunityID=' + this.resourceId + '&outFields=OBJECTID&f=json').then(response => {
                axios.get('https://maps.prochamps.com/agsserver/rest/services/FPRC/USJurisdictionalBoundsCRM/MapServer/2/' + response.data.features[0].attributes.OBJECTID + '?f=json').then(response => {
                    this.rawbBox = turfExtent(arcgisToGeoJSON(response.data.feature));
                    this.bBox = [
                        [
                            this.rawbBox[0],
                            this.rawbBox[1]
                        ],
                        [
                            this.rawbBox[2],
                            this.rawbBox[3]
                        ]
                    ];
                    window.mapExtent = [
                        [
                            this.rawbBox[0],
                            this.rawbBox[1]
                        ],
                        [
                            this.rawbBox[2],
                            this.rawbBox[3]
                        ]
                    ];
                    if (this.program === 'rental') {
                            map.rental = new mapboxgl.Map({
                            container: 'rental-map',
                            style: 'mapbox://styles/astamm/cjw0xqods2mg51cpfd6pgk9uz',
                            bounds: this.bBox,
                            fitBoundsOptions: {
                                padding: 20
                            },
                            scrollZoom: false
                        });
                    } else if (this.program === 'vacant') {
                        map.vacant = new mapboxgl.Map({
                            container: 'vacant-map',
                            style: 'mapbox://styles/astamm/cjw0y8eas2mew1co5p89ew5sm',
                            bounds: this.bBox,
                            fitBoundsOptions: {
                                padding: 20
                            },
                            scrollZoom: false
                        });
                    }
                    else if (this.program === 'foreclosure') {
                        map[this.program] = new mapboxgl.Map({
                            container: 'foreclosure-map',
                            style: 'mapbox://styles/astamm/cjvmr86s04axk1cponbppvqs7',
                            bounds: this.bBox,
                            fitBoundsOptions: {
                                padding: 20
                            },
                            scrollZoom: false,
                        });
                    }


                    map[this.program].on('style.load', () => {
                        const waiting = () => {
                            if (!map[this.program].isStyleLoaded()) {
                                setTimeout(waiting, 200);
                            } else {
                                const U = require('mapbox-gl-utils').init(map[this.program]);
                                this.$nextTick(() => {
                                    if (this.program === 'vacant' || this.program === 'rental') {
                                        let communityFilter = [
                                            "all",
                                            [
                                                "match",
                                                ["get", "CommCommun"],
                                                [parseInt(this.resourceId)],
                                                true,
                                                false
                                            ]
                                        ];
                                        map[this.program].setFilter('communityrentalvacant', communityFilter);
                                        map[this.program].U.clickLayer(['communityrentalvacant'], (e) => {
                                            if (this.mapClicked) {
                                                let props = e.features[0].properties;
                                                let html = `
                                                <div>
                                                    <h2>${props.NAME}</h2>
                                                    <h4>Total Housing: ${props.TotalHousi}</h4>
                                                    <h4>Total Rental: ${props.RenterOccu}</h4>
                                                    <h4>Total Vacant: ${props.TotalVacan}</h4>
                                                </div>
                                            `;
                                                if (e.features) {
                                                    new mapboxgl.Popup()
                                                        .setLngLat(e.lngLat)
                                                        .setHTML(html)
                                                        .addTo(map[this.program]);
                                                }
                                            }
                                        });
                                    } else if (this.program === 'foreclosure') {
                                        let communityFilter = [
                                            "all",
                                            [
                                                "match",
                                                ["get", "CommunityI"],
                                                [parseInt(this.resourceId)],
                                                true,
                                                false
                                            ]
                                        ];
                                        map[this.program].setFilter('activeforeclosure', communityFilter);
                                    }
                                });
                            }
                        };
                        waiting();
                    });
                })
            });
        }
    }
</script>

<style>
    @import url("https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css");
    .mapboxgl-map { width: 100%; height: 100%; overflow:visible;}
    .map {
        height: 500px;
    }
    .mapboxgl-ctrl-back {
        background-image: url("https://cdn2.iconfinder.com/data/icons/arrows-1-2/416/Arrow_Left3-512.png");
        background-size: contain;
    }
</style>
