/**
 * Ergonosphera — Интерактивная карта мира
 *
 * Leaflet.js + TopoJSON. Полностью автономная.
 * Антимеридианная коррекция. Региональные цвета.
 *
 * Исправления маппинга: Египет (818), Западная Сахара (732 EH),
 * Восточный Тимор (626), Вьетнам (704 VN), Косово (383 XK), Реюньон (638 RE).
 * Французская Гвиана (254 GF) в Юж. Америке — подписана отдельно от метрополии.
 * Французские Южные территории (260 TF) — добавлен маппинг.
 * Вануату (548 VU) — добавлено русское название.
 *
 * @package Ergonosphera
 */
(function() {
    'use strict';

    /* =============================================================
       Цвета регионов
       ============================================================= */
    var COLORS = {
        europe:        '#5B8FD6',
        asia:          '#5EAF5E',
        africa:        '#F0A830',
        north_america: '#E05555',
        south_america: '#9B59B6',
        oceania:       '#1ABC9C',
        antarctica:    '#D5E8F0',
        _default:      '#B0BEC5'
    };

    /* =============================================================
       ISO numeric → регион (полный маппинг)
       ============================================================= */
    var ID_REGION = {};

    // Европа (включая Косово 383)
    [8,20,40,51,56,70,100,112,191,196,203,208,233,234,246,250,
     268,276,292,300,336,348,352,372,380,428,438,440,442,470,
     492,498,499,528,578,616,620,642,643,674,688,703,705,724,
     752,756,804,807,826,383].forEach(function(n){ID_REGION[n]='europe';});

    // Азия (включая Вьетнам 704, Восточный Тимор 626)
    [4,31,48,50,64,96,104,116,144,156,344,356,360,364,368,376,
     392,398,400,408,410,414,417,418,422,458,462,496,512,524,586,
     608,634,682,702,760,762,764,784,792,795,860,704,887,
     158,275,626].forEach(function(n){ID_REGION[n]='asia';});

    // Африка (включая Египет 818, Западная Сахара 732, Реюньон 638)
    [12,24,72,108,120,132,140,148,174,175,178,180,204,226,
     231,232,262,266,270,288,324,384,404,426,430,434,450,454,
     466,478,480,504,508,516,562,566,624,646,686,690,694,706,
     710,716,728,729,748,768,788,800,834,854,894,732,818,638].forEach(function(n){ID_REGION[n]='africa';});

    // Северная Америка
    [28,44,52,84,124,136,188,192,212,214,222,304,308,312,320,
     332,340,388,474,484,533,534,535,558,591,630,652,659,660,
     662,663,670,780,796,840,850].forEach(function(n){ID_REGION[n]='north_america';});

    // Южная Америка (включая Французскую Гвиану 254 — явно, чтобы не путать с метрополией)
    [32,68,76,152,170,218,238,254,328,600,604,740,858,862].forEach(function(n){ID_REGION[n]='south_america';});

    // Океания
    [36,90,242,258,296,520,540,548,554,570,574,580,581,
     582,583,584,585,598,776,798,882].forEach(function(n){ID_REGION[n]='oceania';});

    // Антарктида (включая Французские Южные территории 260)
    [10,260].forEach(function(n){ID_REGION[n]='antarctica';});

    /* =============================================================
       ISO numeric → alpha-2
       ============================================================= */
    var ID_A2 = {
        4:'AF',8:'AL',12:'DZ',16:'AS',20:'AD',24:'AO',28:'AG',32:'AR',
        36:'AU',40:'AT',31:'AZ',44:'BS',48:'BH',50:'BD',51:'AM',52:'BB',
        56:'BE',64:'BT',68:'BO',70:'BA',72:'BW',76:'BR',84:'BZ',90:'SB',
        96:'BN',100:'BG',104:'MM',108:'BI',112:'BY',116:'KH',120:'CM',
        124:'CA',132:'CV',136:'KY',140:'CF',144:'LK',148:'TD',152:'CL',
        156:'CN',158:'TW',170:'CO',174:'KM',175:'YT',178:'CG',180:'CD',
        188:'CR',191:'HR',192:'CU',196:'CY',203:'CZ',204:'BJ',208:'DK',
        212:'DM',214:'DO',218:'EC',222:'SV',226:'GQ',231:'ET',232:'ER',
        233:'EE',234:'FO',238:'FK',242:'FJ',246:'FI',250:'FR',254:'GF',
        258:'PF',262:'DJ',266:'GA',268:'GE',270:'GM',275:'PS',276:'DE',
        288:'GH',292:'GI',296:'KI',300:'GR',304:'GL',308:'GD',312:'GP',
        320:'GT',324:'GN',328:'GY',332:'HT',336:'VA',340:'HN',344:'HK',
        348:'HU',352:'IS',356:'IN',360:'ID',364:'IR',368:'IQ',372:'IE',
        376:'IL',380:'IT',384:'CI',388:'JM',392:'JP',398:'KZ',400:'JO',
        404:'KE',408:'KP',410:'KR',414:'KW',417:'KG',418:'LA',422:'LB',
        426:'LS',428:'LV',430:'LR',434:'LY',438:'LI',440:'LT',442:'LU',
        450:'MG',454:'MW',458:'MY',462:'MV',466:'ML',470:'MT',478:'MR',
        480:'MU',484:'MX',492:'MC',496:'MN',498:'MD',499:'ME',504:'MA',
        508:'MZ',512:'OM',516:'NA',520:'NR',524:'NP',528:'NL',540:'NC',
        548:'VU',554:'NZ',558:'NI',562:'NE',566:'NG',570:'NU',574:'NF',
        578:'NO',580:'MP',581:'UM',582:'MH',583:'FM',584:'PW',585:'PW',
        586:'PK',591:'PA',598:'PG',600:'PY',604:'PE',608:'PH',616:'PL',
        620:'PT',624:'GW',626:'TL',630:'PR',634:'QA',642:'RO',643:'RU',
        646:'RW',652:'BL',659:'KN',660:'AI',662:'LC',663:'MF',670:'VC',
        674:'SM',678:'ST',682:'SA',686:'SN',688:'RS',690:'SC',694:'SL',
        702:'SG',703:'SK',704:'VN',705:'SI',706:'SO',710:'ZA',716:'ZW',724:'ES',
        728:'SS',729:'SD',740:'SR',748:'SZ',752:'SE',756:'CH',760:'SY',
        762:'TJ',764:'TH',768:'TG',776:'TO',780:'TT',784:'AE',788:'TN',
        792:'TR',795:'TM',796:'TC',798:'TV',800:'UG',804:'UA',807:'MK',
        818:'EG',826:'GB',834:'TZ',840:'US',850:'VI',854:'BF',858:'UY',
        860:'UZ',862:'VE',876:'WF',882:'WS',887:'YE',894:'ZM',10:'AQ',
        732:'EH',383:'XK',638:'RE',260:'TF'
    };

    /* =============================================================
       Русские названия
       ============================================================= */
    var RU = {
        'AF':'Афганистан','AL':'Албания','DZ':'Алжир','AD':'Андорра','AO':'Ангола',
        'AG':'Антигуа и Барбуда','AR':'Аргентина','AM':'Армения','AU':'Австралия','AT':'Австрия',
        'AZ':'Азербайджан','BS':'Багамы','BH':'Бахрейн','BD':'Бангладеш','BB':'Барбадос',
        'BY':'Беларусь','BE':'Бельгия','BZ':'Белиз','BJ':'Бенин','BT':'Бутан',
        'BO':'Боливия','BA':'Босния и Герцеговина','BW':'Ботсвана','BR':'Бразилия','BN':'Бруней',
        'BG':'Болгария','BF':'Буркина-Фасо','BI':'Бурунди','KH':'Камбоджа','CM':'Камерун',
        'CA':'Канада','CV':'Кабо-Верде','CF':'ЦАР','TD':'Чад','CL':'Чили',
        'CN':'Китай','TW':'Тайвань','CO':'Колумбия','KM':'Коморы','CD':'ДР Конго','CG':'Конго',
        'CR':'Коста-Рика','CI':'Кот-д\'Ивуар','HR':'Хорватия','CU':'Куба','CY':'Кипр',
        'CZ':'Чехия','DK':'Дания','DJ':'Джибути','DM':'Доминика','DO':'Доминикана',
        'EC':'Эквадор','EG':'Египет','SV':'Сальвадор','GQ':'Экв. Гвинея','ER':'Эритрея',
        'EE':'Эстония','ET':'Эфиопия','FJ':'Фиджи','FI':'Финляндия','FR':'Франция',
        'GA':'Габон','GM':'Гамбия','GE':'Грузия','DE':'Германия','GH':'Гана',
        'GR':'Греция','GD':'Гренада','GT':'Гватемала','GN':'Гвинея','GW':'Гвинея-Бисау',
        'GY':'Гайана','HT':'Гаити','HN':'Гондурас','HU':'Венгрия','IS':'Исландия',
        'IN':'Индия','ID':'Индонезия','IR':'Иран','IQ':'Ирак','IE':'Ирландия',
        'IL':'Израиль','IT':'Италия','JM':'Ямайка','JP':'Япония','JO':'Иордания',
        'KZ':'Казахстан','KE':'Кения','KP':'КНДР','KR':'Южная Корея','KW':'Кувейт',
        'KG':'Киргизия','LA':'Лаос','LV':'Латвия','LB':'Ливан','LS':'Лесото',
        'LR':'Либерия','LY':'Ливия','LI':'Лихтенштейн','LT':'Литва','LU':'Люксембург',
        'MK':'Северная Македония','MG':'Мадагаскар','MW':'Малави','MY':'Малайзия','MV':'Мальдивы',
        'ML':'Мали','MT':'Мальта','MA':'Марокко','MR':'Мавритания','MU':'Маврикий',
        'MX':'Мексика','MD':'Молдова','MN':'Монголия','ME':'Черногория','MZ':'Мозамбик',
        'MM':'Мьянма','NA':'Намибия','NP':'Непал','NL':'Нидерланды','NZ':'Новая Зеландия',
        'NI':'Никарагуа','NE':'Нигер','NG':'Нигерия','NO':'Норвегия','OM':'Оман',
        'PK':'Пакистан','PA':'Панама','PG':'Папуа — Новая Гвинея','PY':'Парагвай','PE':'Перу',
        'PH':'Филиппины','PL':'Польша','PT':'Португалия','QA':'Катар','RO':'Румыния',
        'RU':'Россия','RW':'Руанда','SA':'Саудовская Аравия','SN':'Сенегал','RS':'Сербия',
        'SL':'Сьерра-Леоне','SG':'Сингапур','SK':'Словакия','SI':'Словения','SO':'Сомали',
        'ZA':'ЮАР','ES':'Испания','LK':'Шри-Ланка','SD':'Судан','SR':'Суринам',
        'SZ':'Эсватини','SE':'Швеция','CH':'Швейцария','SY':'Сирия','TJ':'Таджикистан',
        'TZ':'Танзания','TH':'Таиланд','TL':'Восточный Тимор','TG':'Того',
        'TT':'Тринидад и Тобаго','TN':'Тунис','TR':'Турция','TM':'Туркменистан',
        'UG':'Уганда','UA':'Украина','AE':'ОАЭ','GB':'Великобритания','US':'США',
        'UY':'Уругвай','UZ':'Узбекистан','VE':'Венесуэла','VN':'Вьетнам','YE':'Йемен',
        'ZM':'Замбия','ZW':'Зимбабве','SS':'Южный Судан','PS':'Палестина',
        'GL':'Гренландия','NC':'Новая Каледония','PR':'Пуэрто-Рико','SB':'Соломоновы Острова',
        'AQ':'Антарктида','FK':'Фолклендские острова','GF':'Французская Гвиана',
        'EH':'Западная Сахара','XK':'Косово','RE':'Реюньон','VN':'Вьетнам',
        'TF':'Французские Южные территории','VU':'Вануату'
    };

    /* =============================================================
       Утилиты
       ============================================================= */
    function getNumId(feature) {
        var raw = feature.id !== undefined ? feature.id : 
                  (feature.properties ? feature.properties.id : 0);
        return parseInt(raw, 10) || 0;
    }

    function getAlpha2(numId) {
        return ID_A2[numId] || '';
    }

    function getRegion(numId) {
        return ID_REGION[numId] || '_default';
    }

    function getColor(numId) {
        return COLORS[getRegion(numId)] || COLORS._default;
    }

    function getName(a2) {
        return RU[a2] || a2;
    }

    /* =============================================================
       Исправление антимеридиана (180°)
       Россия, Фиджи, Новая Зеландия и т.д.
       ============================================================= */
    function fixAntimeridian(geojson) {
        geojson.features.forEach(function(f) {
            if (!f.geometry) return;
            var t = f.geometry.type;
            if (t === 'Polygon') {
                f.geometry.coordinates.forEach(fixRing);
            } else if (t === 'MultiPolygon') {
                f.geometry.coordinates.forEach(function(poly) {
                    poly.forEach(fixRing);
                });
            }
        });
        return geojson;
    }

    function fixRing(ring) {
        var hasHigh = false, hasLow = false;
        for (var i = 0; i < ring.length; i++) {
            var lng = ring[i][0];
            if (lng > 160) hasHigh = true;
            if (lng < -160) hasLow = true;
        }
        // Если кольцо пересекает антимеридиан — сдвигаем отрицательные
        if (hasHigh && hasLow) {
            for (var j = 0; j < ring.length; j++) {
                if (ring[j][0] < 0) {
                    ring[j][0] += 360;
                }
            }
        }
    }

    /* =============================================================
       Выделение заморских территорий из мульти-полигонов
       Франция (250) → Французская Гвиана (254) в Юж. Америке
       ============================================================= */
    function polyCentroid(coords) {
        // Центроид внешнего кольца (coords[0])
        var ring = coords[0], sx = 0, sy = 0, n = ring.length;
        for (var i = 0; i < n; i++) { sx += ring[i][0]; sy += ring[i][1]; }
        return [sx / n, sy / n];
    }

    function splitOverseasTerritories(geojson) {
        var extra = [];
        geojson.features.forEach(function(f) {
            if (!f.geometry || f.geometry.type !== 'MultiPolygon') return;
            var numId = getNumId(f);

            // Франция (250): полигоны с центроидом lng < -30 → Фр. Гвиана (254)
            if (numId === 250) {
                var keep = [], split = [];
                f.geometry.coordinates.forEach(function(poly) {
                    var c = polyCentroid(poly);
                    if (c[0] < -30) { split.push(poly); }
                    else { keep.push(poly); }
                });
                if (split.length > 0) {
                    f.geometry.coordinates = keep;
                    // Если остался один полигон — упрощаем тип
                    if (keep.length === 1) {
                        f.geometry.type = 'Polygon';
                        f.geometry.coordinates = keep[0];
                    }
                    extra.push({
                        type: 'Feature',
                        id: '254',
                        properties: { name: 'French Guiana' },
                        geometry: split.length === 1
                            ? { type: 'Polygon', coordinates: split[0] }
                            : { type: 'MultiPolygon', coordinates: split }
                    });
                }
            }
        });
        // Добавляем выделенные территории
        for (var i = 0; i < extra.length; i++) {
            geojson.features.push(extra[i]);
        }
        return geojson;
    }

    /* =============================================================
       Карта
       ============================================================= */
    var ErgoMap = {
        map: null,
        geoLayer: null,
        container: null,
        currentTheme: null,
        countryData: {},
        geojsonData: null,

        init: function() {
            this.container = document.getElementById('ergo-world-map');
            if (!this.container) return;
            this.createMap();
            this.loadCountries();
            this.bindControls();
        },

        createMap: function() {
            var loading = this.container.querySelector('.ergo-map-loading');

            this.map = L.map(this.container, {
                center: [20, 0],
                zoom: 2,
                minZoom: 2,
                maxZoom: 7,
                zoomControl: false,
                attributionControl: false,
                worldCopyJump: false,
                maxBoundsViscosity: 1.0,
                maxBounds: [[-85, -200], [85, 200]],
                renderer: L.svg()
            });

            if (loading) loading.style.display = 'none';
        },

        loadCountries: function() {
            var self = this;
            var url = ergoData.themeUrl + '/assets/data/countries-110m.json';

            fetch(url)
                .then(function(r) {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.json();
                })
                .then(function(topo) {
                    // Конвертация через официальную библиотеку
                    var geo = topojson.feature(topo, topo.objects.countries);
                    // Выделение заморских территорий (Фр. Гвиана из Франции)
                    splitOverseasTerritories(geo);
                    // Исправление антимеридиана
                    fixAntimeridian(geo);
                    self.geojsonData = geo;
                    self.renderCountries(geo);
                })
                .catch(function(err) {
                    console.error('Ошибка загрузки карты:', err);
                });
        },

        renderCountries: function(geojson) {
            var self = this;
            if (this.geoLayer) this.map.removeLayer(this.geoLayer);

            this.geoLayer = L.geoJSON(geojson, {
                style: function(feature) {
                    return self.styleFeature(feature);
                },
                onEachFeature: function(feature, layer) {
                    var numId = getNumId(feature);
                    var a2 = getAlpha2(numId);
                    var name = getName(a2);

                    // Tooltip — расширенный при наличии WSC
                    var tip = '<strong>' + name + '</strong>';
                    var wsc = typeof wscMapData !== 'undefined' && wscMapData.active;
                    if (wsc && wscMapData.capitals && wscMapData.capitals[a2]) {
                        tip += '<br><span style="opacity:.8;font-size:12px">🏛 ' +
                               wscMapData.capitals[a2] + '</span>';
                    }
                    if (wsc && wscMapData.population && wscMapData.population[a2]) {
                        var pop = parseInt(wscMapData.population[a2], 10);
                        if (pop > 0) {
                            tip += '<br><span style="opacity:.8;font-size:12px">👥 ' +
                                   pop.toLocaleString('ru-RU') + '</span>';
                        }
                    }
                    if (self.countryData[a2] && self.countryData[a2].label) {
                        tip += '<br><span style="opacity:.75;font-size:12px">' +
                               self.countryData[a2].label + '</span>';
                    }
                    layer.bindTooltip(tip, {
                        sticky: true,
                        direction: 'top',
                        offset: [0, -8],
                        className: 'ergo-map-tip'
                    });

                    layer.on({
                        mouseover: function(e) { self.onHover(e); },
                        mouseout:  function(e) { self.onOut(e); },
                        click:     function(e) { self.onClick(a2); }
                    });
                }
            }).addTo(this.map);
        },

        styleFeature: function(feature) {
            var numId = getNumId(feature);
            var a2 = getAlpha2(numId);

            // Данные от плагина?
            if (this.countryData[a2] && this.countryData[a2].color) {
                return {
                    fillColor: this.countryData[a2].color,
                    weight: 0.8, color: '#fff', opacity: 1, fillOpacity: 0.85
                };
            }
            // Региональный цвет
            return {
                fillColor: getColor(numId),
                weight: 0.8, color: '#fff', opacity: 1, fillOpacity: 0.8
            };
        },

        onHover: function(e) {
            e.target.setStyle({
                weight: 2, color: '#2C3E50', fillOpacity: 0.95
            });
            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                e.target.bringToFront();
            }
        },

        onOut: function(e) {
            if (this.geoLayer) this.geoLayer.resetStyle(e.target);
        },

        onClick: function(a2) {
            if (!a2 || a2 === 'AQ') return;

            // WSC интеграция: если плагин World Statistics Core активен — прямая ссылка
            if (typeof wscMapData !== 'undefined' && wscMapData.active && wscMapData.urls && wscMapData.urls[a2]) {
                window.location.href = wscMapData.urls[a2];
                return;
            }

            // Фолбэк: стандартная ссылка темы
            if (typeof ergoData !== 'undefined') {
                window.location.href = ergoData.homeUrl + 'country/?code=' + a2.toLowerCase();
            }
        },

        bindControls: function() {
            var self = this;
            var zi = document.getElementById('map-zoom-in');
            var zo = document.getElementById('map-zoom-out');
            var re = document.getElementById('map-reset');
            if (zi) zi.addEventListener('click', function() { self.map.zoomIn(); });
            if (zo) zo.addEventListener('click', function() { self.map.zoomOut(); });
            if (re) re.addEventListener('click', function() { self.map.setView([20, 0], 2); });
        },

        /* --- API для плагинов --- */
        colorize: function(data) {
            this.countryData = (data && data.countries) ? data.countries : {};
            if (this.geojsonData) this.renderCountries(this.geojsonData);
        },

        updateLegend: function(ld) {
            var el = document.getElementById('map-legend');
            var rl = document.getElementById('map-region-legend');
            if (!el) return;
            if (!ld || !ld.title) {
                el.hidden = true;
                if (rl) rl.hidden = false;
                return;
            }
            el.hidden = false;
            if (rl) rl.hidden = true; // Скрыть легенду регионов когда показана легенда плагина
            var t = document.getElementById('legend-title');
            var s = document.getElementById('legend-scale');
            var mn = document.getElementById('legend-min');
            var mx = document.getElementById('legend-max');
            var u  = document.getElementById('legend-unit');
            if (t) t.textContent = ld.title;
            if (mn) mn.textContent = ld.labels ? ld.labels[0] : (ld.min || '');
            if (mx) mx.textContent = ld.labels ? ld.labels[ld.labels.length-1] : (ld.max || '');
            if (u)  u.textContent  = ld.unit || '';
            if (s && ld.colors) {
                s.style.background = 'linear-gradient(to right,' +
                    ld.colors.map(function(c,i){
                        return c+' '+(i/(ld.colors.length-1)*100)+'%';
                    }).join(',')+')';
            }
        },

        loadThemeData: function(themeId) {
            var self = this;
            this.currentTheme = themeId;
            if (!themeId) { this.colorize(null); this.updateLegend(null); return; }

            var fd = new FormData();
            fd.append('action','ergo_get_map_data');
            fd.append('nonce', ergoData.nonce);
            fd.append('theme_id', themeId);

            fetch(ergoData.ajaxUrl, {method:'POST', body:fd})
                .then(function(r){return r.json();})
                .then(function(resp){
                    if (resp.success) {
                        self.colorize(resp.data.map_data);
                        self.updateLegend(resp.data.legend);
                    }
                })
                .catch(function(e){ console.error('Map data error:', e); });
        }
    };

    window.ErgoMap = ErgoMap;

    document.addEventListener('DOMContentLoaded', function() {
        ErgoMap.init();
        var p = new URLSearchParams(window.location.search);
        var th = p.get('theme');
        if (th) {
            var sel = document.getElementById('ergo-theme-select');
            if (sel) { sel.value = th; sel.dispatchEvent(new Event('change')); }
        }
    });
})();
