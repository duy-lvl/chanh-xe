<?php

namespace Database\Seeders;

use App\Models\Partner;
use Clickbar\Magellan\Data\Geometries\Point;
use Domain\CustomerFacing\Enums\PackageType;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

final class PartnerSeeder extends Seeder
{
    private $partnerData = [
        [
            'name' => 'Công ty xe khách Hùng Cường',
            'username' => 'hungcuong123',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'bank_account_number' => '0123 4567 8910',
            'bank_account_name' => 'Công ty xe khách Hùng Cường',
            'bank_code' => 'Vietcombank',
            'phones' => [
                '02838572624',
                '02839555041',
                '02839551247',
                '02839561623',
            ],
            'stations' => [
                [
                    'tmp_id' => 1,
                    'name' => 'Văn phòng nhà xe Hùng Cường ở TP. Hồ Chí Minh',
                    'address' => '48 Phó Cơ Điều, Phường 12, Quận 5, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '774',
                    'ward_code' => '27310',
                    'latitude' => 10.757303246238495,
                    'longitude' => 106.657246642305850,
                ],
                [
                    'tmp_id' => 2,
                    'name' => 'Hùng Cường Châu Đốc',
                    'address' => '96 Đống Đa, Châu Phú A, Châu Đốc, An Giang, Việt Nam',
                    'city_code' => '89',
                    'district_code' => '884',
                    'ward_code' => '30319',
                    'latitude' => 10.71062375626563,
                    'longitude' => 105.11706567862724,
                ],
                [
                    'tmp_id' => 3,
                    'name' => 'Chi Nhánh Công Ty TNHH Vận Tải Hùng Cường',
                    'address' => '001 - C2 Lý Thái Tổ, Mỹ Long, Long Xuyên, Tỉnh An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30283',
                    'latitude' => 10.380419324564455,
                    'longitude' => 105.44600174231454,
                ],
                [
                    'tmp_id' => 4,
                    'name' => 'Trạm xe Hùng Cường ở thị trấn Long Bình, Long Phú, An Giang',
                    'address' => 'Ấp 1, Thị Trấn Long Bình',
                    'city_code' => '89',
                    'district_code' => '886',
                    'ward_code' => '30341',
                    'latitude' => 10.952889394018595,
                    'longitude' => 105.09183331110032,
                ],
                [
                    'tmp_id' => 5,
                    'name' => 'Trạm xe Hùng Cường ở thị trấn An Phú, huyện An Phú, An Giang',
                    'address' => 'Ấp An Thịnh, Thị Trấn An Phú',
                    'city_code' => '89',
                    'district_code' => '886',
                    'ward_code' => '30337',
                    'latitude' => 10.953519244906452,
                    'longitude' => 105.10175037612623,
                ],
                [
                    'tmp_id' => 6,
                    'name' => 'Trạm xe Hùng Cường ở Tịnh Biên, An Giang',
                    'address' => '459Đ, Khóm Xuân Hoà, huyện An Phú, Tịnh Biên, Tỉnh An Giang',
                    'city_code' => '89',
                    'district_code' => '890',
                    'ward_code' => '30337',
                    'latitude' => 10.620098943010042,
                    'longitude' => 104.96810901723897,
                ],
                [
                    'tmp_id' => 7,
                    'name' => 'Trạm xe Hùng Cường ở Thoại Sơn, An Giang',
                    'address' => '136 Tân Hiệp, Óc Eo, Thoại Sơn, Tỉnh An Giang',
                    'city_code' => '89',
                    'district_code' => '894',
                    'ward_code' => '30688',
                    'latitude' => 10.274596806575936,
                    'longitude' => 105.18301649628128,
                ],
                [
                    'tmp_id' => 8,
                    'name' => 'Trạm xe Hùng Cường ở Vịnh Tre, An Giang',
                    'address' => 'Vĩnh Thuận, Vĩnh Thạnh Trung, Châu Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '889',
                    'ward_code' => '30478',
                    'latitude' => 10.61506034422161,
                    'longitude' => 105.2099543226254,
                ],
                [
                    'tmp_id' => 9,
                    'name' => 'Hùng Cường Cần Thơ',
                    'address' => '2Q4F+74R, Đường dẫn cầu Cần Thơ, QL1A, Hưng Thạnh, Cái Răng, Cần Thơ, Việt Nam',
                    'city_code' => '92',
                    'district_code' => '919',
                    'ward_code' => '31192',
                    'latitude' => 10.005806112107779,
                    'longitude' => 105.77275569630451,
                ],
            ],
            'routes' => [
                [
                    'name' => 'Tuyến Sài Gòn - Tịnh Biên',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '89',
                    'end_district_code' => '890',

                    'milestones' => [
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 68200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 180000,

                        ],
                        [
                            'tmp_station_id' => 8,
                            'distance_from_previous' => 43900,
                        ],
                        [
                            'tmp_station_id' => 2,
                            'distance_from_previous' => 22300,
                        ],
                        [
                            'tmp_station_id' => 6,
                            'distance_from_previous' => 44300,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - An Phú',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '89',
                    'end_district_code' => '886',

                    'milestones' => [
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 68200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 180000,

                        ],
                        [
                            'tmp_station_id' => 4,
                            'distance_from_previous' => 87800,
                        ],
                        [
                            'tmp_station_id' => 5,
                            'distance_from_previous' => 18600,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Thoại Sơn',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '89',
                    'end_district_code' => '894',

                    'milestones' => [
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 68200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 180000,

                        ],
                        [
                            'tmp_station_id' => 7,
                            'distance_from_previous' => 38700,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Cần Thơ - Thoại Sơn',
                    'start_city_code' => '92',
                    'start_district_code' => '919',
                    'end_city_code' => '89',
                    'end_district_code' => '894',

                    'milestones' => [
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 3200,
                            ]
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 65500,

                        ],
                        [
                            'tmp_station_id' => 7,
                            'distance_from_previous' => 38700,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Cần Thơ - Tịnh Biên',
                    'start_city_code' => '92',
                    'start_district_code' => '919',
                    'end_city_code' => '89',
                    'end_district_code' => '890',

                    'milestones' => [
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 3200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 65500,

                        ],
                        [
                            'tmp_station_id' => 8,
                            'distance_from_previous' => 43900,
                        ],
                        [
                            'tmp_station_id' => 2,
                            'distance_from_previous' => 22300,
                        ],
                        [
                            'tmp_station_id' => 6,
                            'distance_from_previous' => 44300,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Cần Thơ - An Phú',
                    'start_city_code' => '92',
                    'start_district_code' => '919',
                    'end_city_code' => '89',
                    'end_district_code' => '886',

                    'milestones' => [
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 3200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 65500,

                        ],
                        [
                            'tmp_station_id' => 4,
                            'distance_from_previous' => 87800,
                        ],
                        [
                            'tmp_station_id' => 5,
                            'distance_from_previous' => 18600,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Cần Thơ - Sài Gòn',
                    'start_city_code' => '92',
                    'start_district_code' => '919',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 3200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 156000,

                        ],
                    ],
                ],
                //==================
                [
                    'name' => 'Tuyến Tịnh Biên - Sài Gòn',
                    'start_city_code' => '89',
                    'start_district_code' => '890',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 6,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 2,
                            'distance_from_previous' => 44300,
                        ],
                        [
                            'tmp_station_id' => 8,
                            'distance_from_previous' => 22300,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 43900,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 130100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 180000,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến An Phú - Sài Gòn',
                    'start_city_code' => '86',
                    'start_district_code' => '886',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 5,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 4,
                            'distance_from_previous' => 18600,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 87800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 130100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 180000,
                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Thoại Sơn - Sài Gòn',
                    'start_city_code' => '89',
                    'start_district_code' => '894',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 7,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 38700,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 130100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 180000,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Thoại Sơn - Cần Thơ',
                    'start_city_code' => '89',
                    'start_district_code' => '894',
                    'end_city_code' => '92',
                    'end_district_code' => '919',

                    'milestones' => [
                        [
                            'tmp_station_id' => 7,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 38700,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 66100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 77200,

                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Tịnh Biên - Cần Thơ',
                    'start_city_code' => '89',
                    'start_district_code' => '890',
                    'end_city_code' => '92',
                    'end_district_code' => '919',

                    'milestones' => [
                        [
                            'tmp_station_id' => 6,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 2,
                            'distance_from_previous' => 44300,
                        ],
                        [
                            'tmp_station_id' => 8,
                            'distance_from_previous' => 22300,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 43900,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 66100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 77200,
                        ],
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 77200,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến An Phú - Cần Thơ',
                    'start_city_code' => '89',
                    'start_district_code' => '886',
                    'end_city_code' => '92',
                    'end_district_code' => '919',

                    'milestones' => [
                        [
                            'tmp_station_id' => 5,
                            'distance_from_previous' => 0,
                        ],
                        [
                            'tmp_station_id' => 4,
                            'distance_from_previous' => 18600,
                        ],
                        [
                            'tmp_station_id' => 3,
                            'distance_from_previous' => 87800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 66100,
                            ],
                        ],
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 77200,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Cần Thơ',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '92',
                    'end_district_code' => '919',

                    'milestones' => [
                        [
                            'tmp_station_id' => 1,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 152800,
                            ],

                        ],
                        [
                            'tmp_station_id' => 9,
                            'distance_from_previous' => 156000,
                        ],

                    ],
                ],
            ],
        ],
        [
            'name' => 'Xe Thịnh Phát',
            'username' => 'thinhphat',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'bank_account_number' => '0123 7890 4567',
            'bank_account_name' => 'Công ty Xe Thịnh Phát',
            'bank_code' => 'Agribank',
            'phones' => [
                '0838303042',
                '0838393625',
                '0913965050',
                '0838338812',
            ],
            'stations' => [
                [
                    'tmp_id' => 10,
                    'name' => 'Văn phòng Thịnh Phát Hồ Chí Minh',
                    'address' => '25A Sư Vạn Hạnh, phường 9, Quận 5, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '774',
                    'ward_code' => '27304',
                    'latitude' => 10.760575313613506,
                    'longitude' => 106.67314851075137,
                ],
                [
                    'tmp_id' => 11,
                    'name' => 'Quầy vé Thịnh Phát quầy số 20 bến xe miền tây',
                    'address' => '395 Kinh Dương Vương, phường An Lạc, quận Bình Tân, Tp HCM',
                    'city_code' => '79',
                    'district_code' => '777',
                    'ward_code' => '27460',
                    'latitude' => 10.741236370031972,
                    'longitude' => 106.61896392424357,
                ],
                [
                    'tmp_id' => 12,
                    'name' => 'Văn phòng Thịnh Phát Bến Tre',
                    'address' => '82A1 Đại Lộ Đồng Khởi, phường Phú Khương, Bến Tre',
                    'city_code' => '83',
                    'district_code' => '829',
                    'ward_code' => '28756',
                    'latitude' => 10.255800410575484,
                    'longitude' => 106.36795013739327,
                ],
                [
                    'tmp_id' => 13,
                    'name' => 'Văn phòng Thịnh Phát Tiền Giang',
                    'address' => '19/5 Nguyễn Thị Thập, phường 6, Tp Mỹ Tho',
                    'city_code' => '82',
                    'district_code' => '815',
                    'ward_code' => '28270',
                    'latitude' => 10.377024656872699,
                    'longitude' => 106.341383880059,
                ],
            ],
            'routes' => [
                [
                    'name' => 'Tuyến Sài Gòn - Tiền Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '82',
                    'end_district_code' => '815',

                    'milestones' => [
                        [
                            'tmp_station_id' => 10,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 65700,
                            ],
                        ],
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 67300,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Tiền Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '777',
                    'end_city_code' => '82',
                    'end_district_code' => '815',

                    'milestones' => [
                        [
                            'tmp_station_id' => 11,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 59300,
                            ],
                        ],
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 60900,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Bến Tre',
                    'start_city_code' => '79',
                    'start_district_code' => '774',
                    'end_city_code' => '83',
                    'end_district_code' => '829',

                    'milestones' => [
                        [
                            'tmp_station_id' => 10,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 65700,
                            ],
                        ],
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 81100,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Bến Tre',
                    'start_city_code' => '79',
                    'start_district_code' => '777',
                    'end_city_code' => '83',
                    'end_district_code' => '829',

                    'milestones' => [
                        [
                            'tmp_station_id' => 11,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 59300,
                            ],
                        ],
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 74700,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Tiền Giang - Bến Tre',
                    'start_city_code' => '82',
                    'start_district_code' => '815',
                    'end_city_code' => '83',
                    'end_district_code' => '829',

                    'milestones' => [
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 1600,
                            ],
                        ],
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 17000,

                        ],

                    ],
                ],
                //===========================
                [
                    'name' => 'Tuyến Tiền Giang - Sài Gòn',
                    'start_city_code' => '82',
                    'start_district_code' => '815',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 1600,
                            ],
                        ],
                        [
                            'tmp_station_id' => 10,
                            'distance_from_previous' => 67300,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Tiền Giang - Sài Gòn',
                    'start_city_code' => '82',
                    'start_district_code' => '815',
                    'end_city_code' => '79',
                    'end_district_code' => '777',

                    'milestones' => [
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 1600,
                            ],
                        ],
                        [
                            'tmp_station_id' => 11,
                            'distance_from_previous' => 60900,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Bến Tre - Sài Gòn',
                    'start_city_code' => '83',
                    'start_district_code' => '829',
                    'end_city_code' => '79',
                    'end_district_code' => '774',

                    'milestones' => [
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 15400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 10,
                            'distance_from_previous' => 81100,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Bến Tre - Sài Gòn',
                    'start_city_code' => '83',
                    'start_district_code' => '829',
                    'end_city_code' => '79',
                    'end_district_code' => '777',

                    'milestones' => [
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 15400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 11,
                            'distance_from_previous' => 74700,

                        ],

                    ],
                ],
                [
                    'name' => 'Tuyến Bến Tre - Tiền Giang',
                    'start_city_code' => '83',
                    'start_district_code' => '829',
                    'end_city_code' => '82',
                    'end_district_code' => '815',

                    'milestones' => [
                        [
                            'tmp_station_id' => 12,
                            'distance_from_previous' => 0,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 15400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 13,
                            'distance_from_previous' => 17000,

                        ],

                    ],
                ],
            ],
        ],
        [
            'name' => 'Công ty cổ phần vận tải Sài Gòn',
            'username' => 'ctycpvtsg',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'bank_account_number' => '1123 4567 8910',
            'bank_account_name' => 'Công ty cổ phần vận tải Sài Gòn',
            'bank_code' => 'ACB',
            'phones' => [
                '02723787686',
                '02973868686',
            ],
            'stations' => [
                [
                    'tmp_id' => 14,
                    'name' => 'Văn phòng CTCP VTSG TpHCM',
                    'address' => '379 Lê Hồng Phong, Phường 2, Quận 10, TpHCM',
                    'city_code' => '79',
                    'district_code' => '771',
                    'ward_code' => '27190',
                    'latitude' => 10.76394814034917,
                    'longitude' => 106.6757969259817,
                ],
                [
                    'tmp_id' => 15,
                    'name' => 'Chi nhánh CTCP VTSG Long An',
                    'address' => '85 quốc lộ 1A, phường 5, TP Tân An, Long An',
                    'city_code' => '80',
                    'district_code' => '794',
                    'ward_code' => '27680',
                    'latitude' => 10.549769129176468,
                    'longitude' => 106.41568199506797,
                ],
                [
                    'tmp_id' => 16,
                    'name' => 'Đại lý CTCP VTSG Rạch Sỏi',
                    'address' => '168 Mai Thị Hồng Hạnh, Vĩnh Hoà Hiệp, Châu Thành, Kiên Giang, Vietnam',
                    'city_code' => '91',
                    'district_code' => '905',
                    'ward_code' => '30892',
                    'latitude' => 9.947554061412964,
                    'longitude' => 105.13029897509001,
                ],
                [
                    'tmp_id' => 17,
                    'name' => 'Đại lý CTCP VTSG Phú Quốc',
                    'address' => 'Số 4 Nguyễn Chí Thanh, Dương Đông, Phú Quốc, Kiên Giang, Vietnam',
                    'city_code' => '91',
                    'district_code' => '911',
                    'ward_code' => '31078',
                    'latitude' => 10.213723689855405,
                    'longitude' => 103.95873253945416,
                ],
                [
                    'tmp_id' => 18,
                    'name' => 'Đại lý CTCP VTSG An Phú',
                    'address' => 'E1-30, shophouse block E, 36 Bờ Bao Tân Thắng, phường Sơn Kỳ, quận Tân Phú, TpHCM',
                    'city_code' => '79',
                    'district_code' => '767',
                    'ward_code' => '27016',
                    'latitude' => 10.800184465268146,
                    'longitude' => 106.61288716645049,
                ],
                [
                    'tmp_id' => 19,
                    'name' => 'Đại lý CTCP VTSG Dĩ An',
                    'address' => '161 Lý Thường Kiệt, KP Thắng Lợi 2, phường Dĩ An, thành phố Dĩ An, Bình Dương',
                    'city_code' => '74',
                    'district_code' => '724',
                    'ward_code' => '25942',
                    'latitude' => 10.909647128994138,
                    'longitude' => 106.76211605485238,
                ],
                [
                    'tmp_id' => 20,
                    'name' => 'Chi nhánh CTCP VTSG Biên Hoà',
                    'address' => '511 Huỳnh Van Nghệ, KP 3, P. Bửu Long, TP Biên Hoà, Đồng Nai',
                    'city_code' => '75',
                    'district_code' => '731',
                    'ward_code' => '26011',
                    'latitude' => 10.95439922274957,
                    'longitude' => 106.79937572390824,
                ],
                [
                    'tmp_id' => 21,
                    'name' => 'Chi nhánh CTCP VTSG Trà Vinh',
                    'address' => '16a Võ Nguyên Giáp, Phường 7, Trà Vinh, Vietnam',
                    'city_code' => '84',
                    'district_code' => '824',
                    'ward_code' => '29254',
                    'latitude' => 9.91615482017432,
                    'longitude' => 106.31603830877668,
                ],
                [
                    'tmp_id' => 22,
                    'name' => 'Chi nhánh CTCP VTSG Tiền Giang',
                    'address' => '262 Ấp Bắc, phường 5, TP Mỹ Tho, Tiền Giang',
                    'city_code' => '82',
                    'district_code' => '815',
                    'ward_code' => '28249',
                    'latitude' => 10.36920930129193,
                    'longitude' => 106.35295646623025,
                ],
                [
                    'tmp_id' => 23,
                    'name' => 'Chi nhánh CTCP VTSG Bến Tre',
                    'address' => '707/1 Võ Nguyên Giáp, Ấp 1, xã Sơn Đông, TP. Bến Tre',
                    'city_code' => '83',
                    'district_code' => '829',
                    'ward_code' => '28783',
                    'latitude' => 10.256906545172177,
                    'longitude' => 106.36022995373962,
                ],
                [
                    'tmp_id' => 24,
                    'name' => 'Chi nhánh CTCP VTSG Vĩnh Long',
                    'address' => '17D Phan Văn Đáng, khóm 1, phường 8, TP Vĩnh Long',
                    'city_code' => '86',
                    'district_code' => '855',
                    'ward_code' => '29560',
                    'latitude' => 10.24161930565946,
                    'longitude' => 105.95044676622886,
                ],
                [
                    'tmp_id' => 25,
                    'name' => 'Chi nhánh CTCP VTSG Sóc Trăng',
                    'address' => '611 Trần Hưng Đạo, Phường 3, Sóc Trăng, Vietnam',
                    'city_code' => '94',
                    'district_code' => '941',
                    'ward_code' => '31519',
                    'latitude' => 9.584748567252015,
                    'longitude' => 105.96388241779796,
                ],
                [
                    'tmp_id' => 26,
                    'name' => 'Chi nhánh CTCP VTSG Bạc Liêu',
                    'address' => 'Số 05, khóm 02, khu vực bến xe, phường 7, Bạc Liêu',
                    'city_code' => '95',
                    'district_code' => '954',
                    'ward_code' => '31822',
                    'latitude' => 9.306138505128114,
                    'longitude' => 105.71992283621904,
                ],
                [
                    'tmp_id' => 27,
                    'name' => 'Chi nhánh CTCP VTSG Cà Mau',
                    'address' => '135/63 Lý Thường Kiệt, phường 6, Tp Cà Mau',
                    'city_code' => '96',
                    'district_code' => '964',
                    'ward_code' => '32017',
                    'latitude' => 9.175654255746142,
                    'longitude' => 105.16838955293386,
                ],
                [
                    'tmp_id' => 28,
                    'name' => 'Chi nhánh CTCP VTSG Thốt Nốt',
                    'address' => 'Cạnh 312, Cây Sao, QL91, TT. Thốt Nốt, Thốt Nốt, Cần Thơ, Vietnam',
                    'city_code' => '92',
                    'district_code' => '923',
                    'ward_code' => '31270',
                    'latitude' => 10.175039411162459,
                    'longitude' => 105.55052560877047,
                ],
                [
                    'tmp_id' => 29,
                    'name' => 'Chi nhánh CTCP VTSG Long Xuyên',
                    'address' => '88 Trần Hưng Đạo, phường Mỹ Bình, Long Xuyên, An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30280',
                    'latitude' => 10.388620178264903,
                    'longitude' => 105.43153121062133,
                ],
                [
                    'tmp_id' => 30,
                    'name' => 'Chi nhánh CTCP VTSG Đồng Tháp',
                    'address' => '106 Lê Lợi, phường 2, Cao Lãnh, Đồng Tháp',
                    'city_code' => '87',
                    'district_code' => '866',
                    'ward_code' => '29869',
                    'latitude' => 10.455575851511961,
                    'longitude' => 105.63968719528071,
                ],

            ],
            'routes' => [
                [
                    'name' => 'Tuyến Sài Gòn - Trà Vinh',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '84',
                    'end_district_code' => '824',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 21,
                            'distance_from_previous' => 62000,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Bến Tre',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '83',
                    'end_district_code' => '829',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 23,
                            'distance_from_previous' => 14400,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - Cà Mau',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '96',
                    'end_district_code' => '964',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 25,
                            'distance_from_previous' => 105000,
                        ],
                        [
                            'tmp_station_id' => 26,
                            'distance_from_previous' => 46200,
                        ],
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 64900,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - An Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '89',
                    'end_district_code' => '883',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 29,
                            'distance_from_previous' => 16900,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Kiên Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '96',
                    'end_district_code' => '964',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 17,
                            'distance_from_previous' => 240000,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - Cà Mau',
                    'start_city_code' => '79',
                    'start_district_code' => '771',
                    'end_city_code' => '96',
                    'end_district_code' => '964',

                    'milestones' => [
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 41100,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 16,
                            'distance_from_previous' => 65800,
                        ],
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 111000,
                        ],
                    ],
                ],
                //======
                [
                    'name' => 'Tuyến Sài Gòn - Trà Vinh',
                    'start_city_code' => '79',
                    'start_district_code' => '767',
                    'end_city_code' => '84',
                    'end_district_code' => '824',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 21,
                            'distance_from_previous' => 62000,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Bến Tre',
                    'start_city_code' => '79',
                    'start_district_code' => '767',
                    'end_city_code' => '83',
                    'end_district_code' => '829',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 23,
                            'distance_from_previous' => 14400,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - Cà Mau',
                    'start_city_code' => '79',
                    'start_district_code' => '767',
                    'end_city_code' => '96',
                    'end_district_code' => '964',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 25,
                            'distance_from_previous' => 105000,
                        ],
                        [
                            'tmp_station_id' => 26,
                            'distance_from_previous' => 46200,
                        ],
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 64900,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - An Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '767',
                    'end_city_code' => '89',
                    'end_district_code' => '883',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 29,
                            'distance_from_previous' => 16900,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Sài Gòn - Kiên Giang',
                    'start_city_code' => '79',
                    'start_district_code' => '767',
                    'end_city_code' => '91',
                    'end_district_code' => '911',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 17,
                            'distance_from_previous' => 240000,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Sài Gòn - Cà Mau',
                    'start_city_code' => '79',
                    'start_district_code' => '794',
                    'end_city_code' => '96',
                    'end_district_code' => '964',

                    'milestones' => [
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 49800,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 21200,
                            ],
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 73000,
                            ],
                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 16,
                            'distance_from_previous' => 65800,
                        ],
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 111000,
                        ],
                    ],
                ],
                //======
                [
                    'name' => 'Tuyến Trà Vinh - Sài Gòn',
                    'start_city_code' => '84',
                    'start_district_code' => '824',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 21,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 62000,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Bến Tre - Sài Gòn',
                    'start_city_code' => '83',
                    'start_district_code' => '829',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 23,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 14400,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,
                        ],
                    ],

                ],

                [
                    'name' => 'Tuyến Cà Mau - Sài Gòn',
                    'start_city_code' => '96',
                    'start_district_code' => '964',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 26,
                            'distance_from_previous' => 64900,

                        ],
                        [
                            'tmp_station_id' => 25,
                            'distance_from_previous' => 46200,
                        ],

                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 105000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến An Giang - Sài Gòn',
                    'start_city_code' => '89',
                    'start_district_code' => '883',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 29,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 16900,

                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],

                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,

                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Kiên Giang - Sài Gòn',
                    'start_city_code' => '91',
                    'start_district_code' => '911',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 17,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 240000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Cà Mau - Sài Gòn',
                    'start_city_code' => '96',
                    'start_district_code' => '964',
                    'end_city_code' => '79',
                    'end_district_code' => '771',

                    'milestones' => [
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 16,
                            'distance_from_previous' => 111000,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 240000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 14,
                            'distance_from_previous' => 41100,
                        ],
                    ],
                ],
                //======
                [
                    'name' => 'Tuyến Trà Vinh - Sài Gòn',
                    'start_city_code' => '84',
                    'start_district_code' => '824',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 21,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 62000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,
                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Bến Tre - Sài Gòn',
                    'start_city_code' => '83',
                    'start_district_code' => '829',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 23,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 14400,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,
                        ],
                    ],

                ],

                [
                    'name' => 'Tuyến Cà Mau - Sài Gòn',
                    'start_city_code' => '96',
                    'start_district_code' => '964',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 26,
                            'distance_from_previous' => 64900,

                        ],
                        [
                            'tmp_station_id' => 25,
                            'distance_from_previous' => 46200,
                        ],

                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 105000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến An Giang - Sài Gòn',
                    'start_city_code' => '89',
                    'start_district_code' => '883',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 29,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 16900,

                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],

                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 1,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,

                        ],
                    ],
                ],
                [
                    'name' => 'Tuyến Kiên Giang - Sài Gòn',
                    'start_city_code' => '91',
                    'start_district_code' => '911',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 17,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 240000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,
                        ],
                    ],
                ],

                [
                    'name' => 'Tuyến Cà Mau - Sài Gòn',
                    'start_city_code' => '96',
                    'start_district_code' => '964',
                    'end_city_code' => '79',
                    'end_district_code' => '767',

                    'milestones' => [
                        [
                            'tmp_station_id' => 27,
                            'distance_from_previous' => 0,

                        ],
                        [
                            'tmp_station_id' => 16,
                            'distance_from_previous' => 111000,

                        ],
                        [
                            'tmp_station_id' => 28,
                            'distance_from_previous' => 240000,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 49400,
                            ],
                        ],
                        [
                            'tmp_station_id' => 24,
                            'distance_from_previous' => 124000,
                        ],
                        [
                            'tmp_station_id' => 22,
                            'distance_from_previous' => 77300,
                            'hubs' => [
                                'id' => 2,
                                'distance_from_milestone' => 2900,
                            ],
                        ],
                        [
                            'tmp_station_id' => 15,
                            'distance_from_previous' => 23700,
                        ],
                        [
                            'tmp_station_id' => 18,
                            'distance_from_previous' => 49800,
                        ],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Nhà xe Huệ Nghĩa',
            'username' => 'huenghia',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'bank_account_number' => '8875 4567 2156',
            'bank_account_name' => 'Nhà xe Huệ Nghĩa',
            'bank_code' => 'Vietinbank',
            'phones' => [
                '1900636879',
                '1900638076',
            ],
            'stations' => [
                [
                    'tmp_id' => 31,
                    'name' => 'VP. Huệ Nghĩa Tống Văn Trân TpHCM',
                    'address' => '4 Tống Văn Trân, P5, Q11 TP HCM',
                    'city_code' => '79',
                    'district_code' => '772',
                    'ward_code' => '27211',
                    'latitude' => 10.770920045979935,
                    'longitude' => 106.64340589528545,
                ],
                [
                    'tmp_id' => 32,
                    'name' => 'VP. Huệ Nghĩa Limousine Lê Đại Hành TP HCM',
                    'address' => '11 Lê Đại Hành, P4, Q11 TP HCM',
                    'city_code' => '79',
                    'district_code' => '772',
                    'ward_code' => '27244',
                    'latitude' => 10.758953853942968,
                    'longitude' => 106.65896219528531,
                ],
                [
                    'tmp_id' => 33,
                    'name' => 'VP. Huệ Nghĩa Kinh Dương Vương TP HCM',
                    'address' => '508 Kinh Dương Vương, An Lạc A, Bình Tân TP HCM',
                    'city_code' => '79',
                    'district_code' => '777',
                    'ward_code' => '27463',
                    'latitude' => 10.738337401578269,
                    'longitude' => 106.61447972227256,
                ],
                [
                    'tmp_id' => 34,
                    'name' => 'VP. Huệ Nghĩa Trường Chinh TP HCM',
                    'address' => '664 Trường Chinh, P15, Tân Bình  TP HCM',
                    'city_code' => '79',
                    'district_code' => '766',
                    'ward_code' => '27007',
                    'latitude' => 10.805633161438427,
                    'longitude' => 106.6355001799444,
                ],
                [
                    'tmp_id' => 35,
                    'name' => 'VP. Huệ Nghĩa An Sương',
                    'address' => '61/1C QL22, Đông Lân, Bà Điểm, Hóc Môn',
                    'city_code' => '79',
                    'district_code' => '784',
                    'ward_code' => '27592',
                    'latitude' => 10.862518701710684,
                    'longitude' => 106.60251902227446,
                ],
                [
                    'tmp_id' => 36,
                    'name' => 'VP. Huệ Nghĩa Bình Dương',
                    'address' => '22/12 Khu Phố 4, Phường An Phú, Thuận An, Bình Dương',
                    'city_code' => '74',
                    'district_code' => '725',
                    'ward_code' => '25975',
                    'latitude' => 10.949259787450227,
                    'longitude' => 106.73264739805376,
                ],
                [
                    'tmp_id' => 37,
                    'name' => 'VP. Huệ Nghĩa Tân Uyên',
                    'address' => 'DT745, Khu Phố 7, Phường Uyên Hưng, Tân Uyên, Bình Dương',
                    'city_code' => '74',
                    'district_code' => '723',
                    'ward_code' => '25888',
                    'latitude' => 11.082336896385725,
                    'longitude' => 106.76579440907543,
                ],
                [
                    'tmp_id' => 38,
                    'name' => 'VP. Huệ Nghĩa Bến Cát',
                    'address' => 'Khu Phố 6, QL13, TT.Mỹ Phước, TX.Bến Cát, Bình Dương',
                    'city_code' => '74',
                    'district_code' => '721',
                    'ward_code' => '25813',
                    'latitude' => 11.375336453130899,
                    'longitude' => 106.62120266616694,
                ],
                [
                    'tmp_id' => 39,
                    'name' => 'VP Huệ Nghĩa Châu Đốc',
                    'address' => '249 Hoàng Diệu, Phường Châu Phú B, Châu Đốc, An Giang',
                    'city_code' => '89',
                    'district_code' => '884',
                    'ward_code' => '30316',
                    'latitude' => 10.699533366413647,
                    'longitude' => 105.11744188179053,
                ],
                [
                    'tmp_id' => 40,
                    'name' => 'VP Huệ Nghĩa Long Xuyên',
                    'address' => '27C/5B Lý Thái Tổ, Phường Mỹ Long, Long Xuyên, An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30283',
                    'latitude' => 10.377664769795798,
                    'longitude' => 105.44160581062113,
                ],
                [
                    'tmp_id' => 41,
                    'name' => 'VP Huệ Nghĩa Năng Gù',
                    'address' => 'ấp Bình Hưng 1, xã Bình Mỹ, Châu Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '889',
                    'ward_code' => '30487',
                    'latitude' => 10.522356837863809,
                    'longitude' => 105.30712160844676,
                ],
                [
                    'tmp_id' => 42,
                    'name' => 'VP Huệ Nghĩa Tịnh Biên',
                    'address' => 'Khóm Xuân Hoà, TT Tịnh Biên, An Giang',
                    'city_code' => '89',
                    'district_code' => '890',
                    'ward_code' => '30502',
                    'latitude' => 10.619685024348012,
                    'longitude' => 104.95140646238585,
                ],
                [
                    'tmp_id' => 43,
                    'name' => 'VP Huệ Nghĩa Châu Thành',
                    'address' => 'ấp Long Hoà 3, TT An Châu, Châu Thành, An Giang',
                    'city_code' => '89',
                    'district_code' => '892',
                    'ward_code' => '30589',
                    'latitude' => 10.442879616850437,
                    'longitude' => 105.38959993267424,
                ],
                [
                    'tmp_id' => 44,
                    'name' => 'VP Huệ Nghĩa Cái Dầu',
                    'address' => 'ấp Bình Chánh, xã Bình Long, Châu Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '889',
                    'ward_code' => '30484',
                    'latitude' => 10.501073366582656,
                    'longitude' => 105.24215314787651,
                ],
                [
                    'tmp_id' => 45,
                    'name' => 'VP Huệ Nghĩa Vịnh Tre',
                    'address' => 'Chợ Vịnh Tre, Vĩnh Thạnh Trung, Châu Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '889',
                    'ward_code' => '30487',
                    'latitude' => 10.615437993993883,
                    'longitude' => 105.21003882596631,
                ],
                [
                    'tmp_id' => 46,
                    'name' => 'VP Huệ Nghĩa Cần Thảo',
                    'address' => 'Ấp Mỹ Thiện, xã Mỹ Phú, Châu Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '889',
                    'ward_code' => '30472',
                    'latitude' => 10.568381526562634,
                    'longitude' => 105.2681114402089,
                ],
                [
                    'tmp_id' => 47,
                    'name' => 'VP Huệ Nghĩa Chi Lăng',
                    'address' => 'Khóm 3, TT Chi Lăng, Tịnh Biên, An Giang',
                    'city_code' => '89',
                    'district_code' => '890',
                    'ward_code' => '30505',
                    'latitude' => 10.43843943705831,
                    'longitude' => 104.99882223319622,
                ],
                [
                    'tmp_id' => 48,
                    'name' => 'VP Huệ Nghĩa An Phú',
                    'address' => 'ấp An Thịnh, TT An Phú, An Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '886',
                    'ward_code' => '30337',
                    'latitude' => 10.789945133475785,
                    'longitude' => 105.09579744331278,
                ],
                [
                    'tmp_id' => 49,
                    'name' => 'VP Huệ Nghĩa Long Bình',
                    'address' => 'ấp Tân Thạnh, TT Long Bình, An Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '886',
                    'ward_code' => '30341',
                    'latitude' => 10.957445238669413,
                    'longitude' => 105.11955842065785,
                ],
                [
                    'tmp_id' => 50,
                    'name' => 'VP Huệ Nghĩa Đồng Ky',
                    'address' => 'ấp Đồng Ky, xã Quốc Thái, An Phú, An Giang',
                    'city_code' => '89',
                    'district_code' => '886',
                    'ward_code' => '30346',
                    'latitude' => 10.919211546396298,
                    'longitude' => 105.0839752045768,
                ],
                [
                    'tmp_id' => 51,
                    'name' => 'VP Huệ Nghĩa An Hoà',
                    'address' => 'ấp An Thuận, xã Hoà Bình, Chợ Mới, An Giang',
                    'city_code' => '89',
                    'district_code' => '893',
                    'ward_code' => '30676',
                    'latitude' => 10.891924099564296,
                    'longitude' => 105.0729507360597,
                ],
                [
                    'tmp_id' => 52,
                    'name' => 'VP Huệ Nghĩa Tri Tôn',
                    'address' => 'Khóm 3, TT Tri Tôn, Tri Tôn, An Giang',
                    'city_code' => '89',
                    'district_code' => '891',
                    'ward_code' => '30544',
                    'latitude' => 10.432462936370388,
                    'longitude' => 104.99929870762647,
                ],
                [
                    'tmp_id' => 53,
                    'name' => 'VP Huệ Nghĩa Bình Hoà',
                    'address' => 'BX Châu Thành, ấp Phú Hoà 2, xã Bình Hoà Châu Thành, An Giang',
                    'city_code' => '89',
                    'district_code' => '892',
                    'ward_code' => '30607',
                    'latitude' => 10.453468701960297,
                    'longitude' => 105.34849851801319,
                ],
                [
                    'tmp_id' => 54,
                    'name' => 'VP Huệ Nghĩa Nhà Bàng',
                    'address' => 'Khóm Thới Hoà, Nhà Bàng, Tịnh Biên, An Giang',
                    'city_code' => '89',
                    'district_code' => '890',
                    'ward_code' => '30502',
                    'latitude' => 10.62096284068779,
                    'longitude' => 105.00093679367382,
                ],
                [
                    'tmp_id' => 55,
                    'name' => 'VP Huệ Nghĩa Cựu Hội',
                    'address' => 'Ấp Mỹ Phú, xã Mỹ An, Chợ Mới, An Giang',
                    'city_code' => '89',
                    'district_code' => '893',
                    'ward_code' => '30655',
                    'latitude' => 10.470412960285891,
                    'longitude' => 105.51322756593406,
                ],
                [
                    'tmp_id' => 56,
                    'name' => 'VP Huệ Nghĩa Ba Chúc',
                    'address' => 'Khóm An Hoà A, TT Ba Chúc, Tri Tôn, An Giang',
                    'city_code' => '89',
                    'district_code' => '891',
                    'ward_code' => '30547',
                    'latitude' => 10.49317919175462,
                    'longitude' => 104.91361372759432,
                ],
                [
                    'tmp_id' => 57,
                    'name' => 'VP Huệ Nghĩa Núi Sập',
                    'address' => 'Ấp Bắc Sơn, TT Núi Sập, Thoại Sơn, An Giang',
                    'city_code' => '89',
                    'district_code' => '894',
                    'ward_code' => '30682',
                    'latitude' => 10.265619949885151,
                    'longitude' => 105.26514817652125,
                ],
                [
                    'tmp_id' => 58,
                    'name' => 'VP Huệ Nghĩa Óc Eo',
                    'address' => 'ấp Tân Đông, TT Óc Eo, Thoại Sơn, An Giang',
                    'city_code' => '89',
                    'district_code' => '894',
                    'ward_code' => '30688',
                    'latitude' => 10.24677285791517,
                    'longitude' => 105.14466418656504,
                ],
                [
                    'tmp_id' => 59,
                    'name' => 'VP Huệ Nghĩa Phú Hoà',
                    'address' => 'Ấp Phú Hữu, TT Phú Hoà, Thoại Sơn, An Giang',
                    'city_code' => '89',
                    'district_code' => '894',
                    'ward_code' => '29869',
                    'latitude' => 10.363230015334018,
                    'longitude' => 105.37714066319795,
                ],
                [
                    'tmp_id' => 60,
                    'name' => 'VP Huệ Nghĩa Cần Đăng',
                    'address' => 'ấp Cần Thạnh, xã Cần Đăng, Châu Thành, An Giang',
                    'city_code' => '89',
                    'district_code' => '892',
                    'ward_code' => '30685',
                    'latitude' => 10.455058653009399,
                    'longitude' => 105.29631499115364,
                ],
                [
                    'tmp_id' => 61,
                    'name' => 'VP Huệ Nghĩa Lạc Quới',
                    'address' => 'Tổ 6 ấp Vĩnh Hòa, xã Lạc Quới, huyện Tri Tôn, An Giang',
                    'city_code' => '89',
                    'district_code' => '891',
                    'ward_code' => '30550',
                    'latitude' => 10.637818533032693,
                    'longitude' => 105.19088750004467,
                ],

                //////
                [
                    'tmp_id' => 62,
                    'name' => 'VP Huệ Nghĩa Tây Ninh',
                    'address' => 'Trường Hòa, Trường Tây, thị xã Hoà Thành, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '709',
                    'ward_code' => '25648',
                    'latitude' => 11.239436921358864,
                    'longitude' => 106.1374858644396,
                ],
                [
                    'tmp_id' => 63,
                    'name' => 'Trạm dừng chân Huệ Nghĩa Gò Dầu',
                    'address' => '15 QL22, Gò Dầu, Tây Ninh, Vietnam',
                    'city_code' => '72',
                    'district_code' => '705',
                    'ward_code' => '25654',
                    'latitude' => 11.079336378712405,
                    'longitude' => 106.27115599131817,
                ],
                [
                    'tmp_id' => 64,
                    'name' => 'VP Huệ Nghĩa Hoà Thành',
                    'address' => '131 Phạm Hùng, KP2, Long Hoa, Hoà Thành, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '709',
                    'ward_code' => '25630',
                    'latitude' => 11.28061647127774,
                    'longitude' => 106.12764660878722,
                ],
                [
                    'tmp_id' => 65,
                    'name' => 'VP Huệ Nghĩa Trảng Bàng',
                    'address' => 'Cx Phước Thành, Tỉnh lộ 19, KP Gia Huỳnh, Trảng Bàng, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '712',
                    'ward_code' => '25708',
                    'latitude' => 11.036698267489049,
                    'longitude' => 106.3603649978826,
                ],
                [
                    'tmp_id' => 66,
                    'name' => 'VP Huệ Nghĩa K13',
                    'address' => 'VX cầu K13, xã Phan, Dương Minh Châu',
                    'city_code' => '72',
                    'district_code' => '702',
                    'ward_code' => '25558',
                    'latitude' => 11.323213664021107,
                    'longitude' => 106.17240789838318,
                ],
                [
                    'tmp_id' => 67,
                    'name' => 'VP Huệ Nghĩa Mộc Bài',
                    'address' => '20 ấp Thuận Tây, Lợi Thuận, Bến Cầu, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '712',
                    'ward_code' => '25699',
                    'latitude' => 11.119790950318626,
                    'longitude' => 106.17629531609178,
                ],
                [
                    'tmp_id' => 68,
                    'name' => 'VP Huệ Nghĩa Ninh Sơn',
                    'address' => '597 Bời Lời, Ninh Sơn, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '703',
                    'ward_code' => '25480',
                    'latitude' => 11.339372735299479,
                    'longitude' => 106.11896762412967,
                ],
                [
                    'tmp_id' => 69,
                    'name' => 'VP Huệ Nghĩa Tân Châu',
                    'address' => 'Thạnh Hiệp, Thạnh Châu, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '703',
                    'ward_code' => '25516',
                    'latitude' => 11.54605050896914,
                    'longitude' => 106.16036186274054,
                ],
                [
                    'tmp_id' => 70,
                    'name' => 'VP Huệ Nghĩa Đất Sét',
                    'address' => 'Thuận Hòa , Truông Mít, Dương Minh Châu, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '707',
                    'ward_code' => '25582',
                    'latitude' => 11.239781962953094,
                    'longitude' => 106.25091932863262,
                ],
                [
                    'tmp_id' => 71,
                    'name' => 'VP Huệ Nghĩa Kà Tum',
                    'address' => 'ấp Đông Thành, xã Tân Đông, Tân Châu, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '706',
                    'ward_code' => '25522',
                    'latitude' => 11.470232914682132,
                    'longitude' => 106.17125664765479,
                ],
                [
                    'tmp_id' => 72,
                    'name' => 'VP Huệ Nghĩa Cẩm Giang',
                    'address' => 'QL 22B , ấp Cẩm Bình, Cẩm Giang, Gò Dầu, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '710',
                    'ward_code' => '25660',
                    'latitude' => 11.369160094832136,
                    'longitude' => 106.05996022006728,
                ],
                [
                    'tmp_id' => 73,
                    'name' => 'VP Huệ Nghĩa Thiên Thộ Lộ',
                    'address' => 'ấp Trường Ân, xã Trường Đông, Hòa Thành, Tây Ninh',
                    'city_code' => '72',
                    'district_code' => '709',
                    'ward_code' => '25642',
                    'latitude' => 11.222714278037357,
                    'longitude' => 106.14740761071272,
                ],
                [
                    'tmp_id' => 74,
                    'name' => 'VP Huệ Nghĩa Hà Tiên',
                    'address' => 'Bến xe Hà Tiên, Thành phố Hà Tiên, Kiên Giang',
                    'city_code' => '91',
                    'district_code' => '900',
                    'ward_code' => '30766',
                    'latitude' => 10.371522918070445,
                    'longitude' => 104.49299349527949,
                ],
                [
                    'tmp_id' => 75,
                    'name' => 'VP Huệ Nghĩa Giang Thành',
                    'address' => 'Tổ 1, ấp Tân Tiến, xã Tân Khánh Hòa, Giang Thành, Kiên Giang',
                    'city_code' => '91',
                    'district_code' => '914',
                    'ward_code' => '30796',
                    'latitude' => 10.482837672202072,
                    'longitude' => 104.68328453877135,
                ],
            ],
        ],
        [
            'name' => 'Công ty cổ phần xe khách Phương Trang',
            'username' => 'futabusline123',
            'email' => 'hotro@futa.vn',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'bank_account_number' => '4462 8752 8910',
            'bank_account_name' => 'Công ty cổ phần xe khách Phương Trang',
            'bank_code' => 'MB',
            'phones' => [
                '02838386852',
                '19006067',
            ],
            'stations' => [
                [
                    'tmp_id' => 76,
                    'name' => 'Nhà chờ xe Phương Trang bến xe Miền Tây',
                    'address' => '383 Đ. Kinh Dương Vương, An Lạc, Bình Tân, Thành phố Hồ Chí Minh, Việt Nam',
                    'city_code' => '79',
                    'district_code' => '777',
                    'ward_code' => '27463',
                    'latitude' => 10.741135646442387,
                    'longitude' => 106.61987059686179,
                ],
                [
                    'tmp_id' => 77,
                    'name' => 'Bến xe Phương Trang Thủ Đức/Q9',
                    'address' => '798 Song Hành Xa Lộ Hà Nội, Hiệp Phú, Quận 9, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '769',
                    'ward_code' => '26839',
                    'latitude' => 10.851048081403201,
                    'longitude' => 106.77703577199452,
                ],
                [
                    'tmp_id' => 78,
                    'name' => 'Xe Khách Phương Trang Trạm Hàng Xanh',
                    'address' => '486J Đ. Điện Biên Phủ, Phường 21, Bình Thạnh, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '765',
                    'ward_code' => '26953',
                    'latitude' => 10.801170770754691,
                    'longitude' => 106.71262257568924,
                ],
                [
                    'tmp_id' => 79,
                    'name' => 'Bến Xe Phương Trang Miền Đông',
                    'address' => ' 373 Đ. Đinh Bộ Lĩnh, Phường 26, Bình Thạnh, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '765',
                    'ward_code' => '26914',
                    'latitude' => 10.81441439568913,
                    'longitude' => 106.71069931062763,
                ],
                [
                    'tmp_id' => 80,
                    'name' => 'Bến xe Phương Trang q10',
                    'address' => '231 Đ. Lê Hồng Phong, phường 1, Quận 10, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '771',
                    'ward_code' => '27184',
                    'latitude' => 10.759737623380111,
                    'longitude' => 106.67752888244098,
                ],
                [
                    'tmp_id' => 81,
                    'name' => 'Xe Phương Trang q10',
                    'address' => '321 Đ. Lê Hồng Phong, Phường 2, Quận 10, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '771',
                    'ward_code' => '27190',
                    'latitude' => 10.759737623380111,
                    'longitude' => 106.67752888244098,
                ],
                [
                    'tmp_id' => 82,
                    'name' => 'Trung chuyển Phương Trang q5',
                    'address' => '202-204 Đ. Lê Hồng Phong, Phường 4, Quận 5, Thành phố Hồ Chí Minh',
                    'city_code' => '79',
                    'district_code' => '771',
                    'ward_code' => '27301',
                    'latitude' => 10.759737623380111,
                    'longitude' => 106.67752888244098,
                ],
                [
                    'tmp_id' => 83,
                    'name' => 'Phương Trang FUTA Express Phan Văn Vàng',
                    'address' => '69 Phan Văn Vàng, Châu Phú A, Châu Đốc, An Giang',
                    'city_code' => '89',
                    'district_code' => '884',
                    'ward_code' => '30319',
                    'latitude' => 10.710216815471826,
                    'longitude' => 105.11828998179074,
                ],
                [
                    'tmp_id' => 84,
                    'name' => 'Phương Trang FUTA Express Châu Đốc',
                    'address' => '95 Nguyễn Hữu Cảnh, Châu Phú A, Châu Đốc, An Giang',
                    'city_code' => '89',
                    'district_code' => '884',
                    'ward_code' => '30319',
                    'latitude' => 10.709814065391617,
                    'longitude' => 105.11815042952811,
                ],
                [
                    'tmp_id' => 85,
                    'name' => 'Xe khách Phương Trang - VP bx Châu Thành',
                    'address' => 'F83X+96J, QL91, Bình Hòa, Châu Thành, An Giang',
                    'city_code' => '89',
                    'district_code' => '892',
                    'ward_code' => '30607',
                    'latitude' => 10.457520567272844,
                    'longitude' => 105.34905846383252,
                ],
                [
                    'tmp_id' => 86,
                    'name' => 'Chi Nhánh An Giang Công Ty Cổ Phần Xe Khách Phương Trang Futabusline',
                    'address' => '99 Hàm Nghi, p. Bình Khánh, Thành phố Long Xuyên, An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30292',
                    'latitude' => 10.393762734380628,
                    'longitude' => 105.42485733945676,
                ],
                [
                    'tmp_id' => 87,
                    'name' => 'Công Ty Xe Khách Phương Trang Long Xuyên',
                    'address' => '392 Phạm Cự Lượng, Mỹ Quý, Thành phố Long Xuyên, An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30298',
                    'latitude' => 10.358939969078722,
                    'longitude' => 105.43411561062088,
                ],
                [
                    'tmp_id' => 88,
                    'name' => 'Futa Buslines Mỹ Thạnh',
                    'address' => '16/35 Trần Hưng Đạo, P. Mỹ Thới, Thành phố Long Xuyên, An Giang',
                    'city_code' => '89',
                    'district_code' => '883',
                    'ward_code' => '30301',
                    'latitude' => 10.359317776737635,
                    'longitude' => 105.45735639527929,
                ],
                [
                    'tmp_id' => 89,
                    'name' => 'Chi nhánh xe Phương Trang Thốt Nốt',
                    'address' => '7G2X+47M, TT. Thốt Nốt, Thốt Nốt, Cần Thơ',
                    'city_code' => '92',
                    'district_code' => '923',
                    'ward_code' => '31207',
                    'latitude' => 10.250473896237269,
                    'longitude' => 105.54842015849171,
                ],
                [
                    'tmp_id' => 90,
                    'name' => 'Phương Trang Ô Môn',
                    'address' => 'KV5 - Quốc Lộ 91 - Q. Ô Môn - TP Cần Thơ',
                    'city_code' => '92',
                    'district_code' => '917',
                    'ward_code' => '31153',
                    'latitude' => 10.10901203735047,
                    'longitude' => 105.61850040876953,
                ],
                [
                    'tmp_id' => 91,
                    'name' => 'Công Ty Cp Vận Tải Dịch Vụ Du Lịch Phương Trang Ninh Kiều',
                    'address' => '13 Đ. Phan Đăng Lưu, Tân An, Ninh Kiều, Cần Thơ',
                    'city_code' => '92',
                    'district_code' => '916',
                    'ward_code' => '31135',
                    'latitude' => 10.04437285602311,
                    'longitude' => 105.78011007993328,
                ],
                [
                    'tmp_id' => 92,
                    'name' => 'Chuyển phát nhanh Phương Trang Ninh Kiều',
                    'address' => '2QF6+PFH, Hưng Lợi, Ninh Kiều, Cần Thơ',
                    'city_code' => '92',
                    'district_code' => '916',
                    'ward_code' => '31147',
                    'latitude' => 10.024513225955442,
                    'longitude' => 105.76123439527453,
                ],
                [
                    'tmp_id' => 93,
                    'name' => 'Phương Trang FUTA Express Cái Răng',
                    'address' => '2Q4F+74R, Đường dẫn cầu Cần Thơ, QL1A, Hưng Thạnh, Cái Răng, Cần Thơ',
                    'city_code' => '92',
                    'district_code' => '919',
                    'ward_code' => '31192',
                    'latitude' => 10.005943932988174,
                    'longitude' => 105.77280561363446,
                ],
                [
                    'tmp_id' => 94,
                    'name' => 'Công Ty Cổ Phần Xe Khách Phương Trang Futabuslines Vị Thanh',
                    'address' => 'QC9V+FXJ, Trần Hưng Đạo, Phường 7, Thảnh Phố Vị Thanh, Tỉnh Hậu Giang',
                    'city_code' => '93',
                    'district_code' => '930',
                    'ward_code' => '31330',
                    'latitude' => 9.774904990471867,
                    'longitude' => 105.45632205109406,
                ],
                [
                    'tmp_id' => 95,
                    'name' => 'Phòng Vé Phương Trang Bến xe Vị Thanh',
                    'address' => 'Bến Xe Vị Thanh, Vị Trung, Vị Thuỷ, Hậu Giang',
                    'city_code' => '93',
                    'district_code' => '930',
                    'ward_code' => '31444',
                    'latitude' => 9.782252264473593,
                    'longitude' => 105.50046946218063,
                ],
                [
                    'tmp_id' => 96,
                    'name' => 'Công Ty Cổ Phần Xe Khách Phương Trang Long Mỹ',
                    'address' => '275 QL 61A, Xã Long Bình, Long Mỹ, Hậu Giang',
                    'city_code' => '93',
                    'district_code' => '936',
                    'ward_code' => '31474',
                    'latitude' => 9.748262428097776,
                    'longitude' => 105.57280544968677,
                ],
                [
                    'tmp_id' => 97,
                    'name' => 'Phương Trang FUTA Express Châu Thành A',
                    'address' => 'Bến xe, TT. Một Ngàn, Châu Thành A, Hậu Giang',
                    'city_code' => '93',
                    'district_code' => '932',
                    'ward_code' => '31342',
                    'latitude' => 9.920520673123434,
                    'longitude' => 105.6537169958654,
                ],
                [
                    'tmp_id' => 98,
                    'name' => 'Nhà Xe Phương Trang Ngã Bảy Hậu Giang',
                    'address' => 'QL1A, Ngã Bảy, Ngã Bảy, Hậu Giang',
                    'city_code' => '93',
                    'district_code' => '932',
                    'ward_code' => '31340',
                    'latitude' => 9.835150604609789,
                    'longitude' => 105.80996510372047,
                ],
                [
                    'tmp_id' => 99,
                    'name' => 'Công Ty Cổ Phần Xe Khách Phương Trang Tắc Vân',
                    'address' => 'Tắc Vân, Tp. Cà Mau, Cà Mau',
                    'city_code' => '96',
                    'district_code' => '964',
                    'ward_code' => '32029',
                    'latitude' => 9.17049226989691,
                    'longitude' => 105.26433060141598,
                ],
                [
                    'tmp_id' => 100,
                    'name' => 'Công Ty Cổ Phần Xe Khách Phương Trang - Bến xe Cà Mau',
                    'address' => '309 Lý Thường Kiệt, Phường 6, Thành phố Cà Mau, Cà Mau',
                    'city_code' => '96',
                    'district_code' => '964',
                    'ward_code' => '32017',
                    'latitude' => 9.192582995813332,
                    'longitude' => 105.18432794922613,
                ],
                [
                    'tmp_id' => 101,
                    'name' => 'Phòng giao dịch Năm Căn Cty Phương Trang FUTA Express',
                    'address' => 'QXGX+CCR, BX Năm Căn, Khóm, Năm Căn, Cà Mau, Việt Nam',
                    'city_code' => '96',
                    'district_code' => '964',
                    'ward_code' => '32191',
                    'latitude' => 8.776253194296148,
                    'longitude' => 104.99856735090289,
                ],
                [
                    'tmp_id' => 102,
                    'name' => 'Phương Trang Đầm Dơi',
                    'address' => '252V+5Q8, Vùng 4, Đầm Dơi, Cà Mau',
                    'city_code' => '96',
                    'district_code' => '970',
                    'ward_code' => '32152',
                    'latitude' => 9.032397725840514,
                    'longitude' => 105.19372571576788,
                ],
                [
                    'tmp_id' => 103,
                    'name' => 'Phương Trang - bến xe Bạc Liêu',
                    'address' => 'Bến xe Bạc Liêu, 1, Phường 7, Bạc Liêu, Việt Nam',
                    'city_code' => '95',
                    'district_code' => '954',
                    'ward_code' => '31822',
                    'latitude' => 9.30302870056963,
                    'longitude' => 105.72032199164374,
                ],
            ],
            // 'routes' => [
            //     [
            //         'name' => 'Sài Gòn -> Cà Mau',
            //         'start_city_code' => '79',
            //         'end_city_code' => '96',
            //         'segment_number_has_hub_id' => [
            //             1 => 1
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 1,
            //                 'tmp_end_station_id' => 27,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 27,
            //                 'tmp_end_station_id' => 25,
            //             ],
            //             [
            //                 'segment_number' => 3,
            //                 'tmp_start_station_id' => 25,
            //                 'tmp_end_station_id' => 26,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => ' Cà Mau -> Sài Gòn',
            //         'start_city_code' => '96',
            //         'end_city_code' => '79',
            //         'segment_number_has_hub_id' => [
            //             3 => 1
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 26,
            //                 'tmp_end_station_id' => 25,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 25,
            //                 'tmp_end_station_id' => 27,
            //             ],
            //             [
            //                 'segment_number' => 3,
            //                 'tmp_start_station_id' => 27,
            //                 'tmp_end_station_id' => 1,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Cần Thơ -> Cà Mau',
            //         'start_city_code' => '92',
            //         'end_city_code' => '96',
            //         'segment_number_has_hub_id' => [
            //             1 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 17,
            //                 'tmp_end_station_id' => 25,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 25,
            //                 'tmp_end_station_id' => 26,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Cà Mau -> Cần Thơ',
            //         'start_city_code' => '96',
            //         'end_city_code' => '92',
            //         'segment_number_has_hub_id' => [
            //             1 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 26,
            //                 'tmp_end_station_id' => 25,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 25,
            //                 'tmp_end_station_id' => 17,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Cần Thơ -> Hậu Giang',
            //         'start_city_code' => '92',
            //         'end_city_code' => '93',
            //         'segment_number_has_hub_id' => [
            //             1 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 17,
            //                 'tmp_end_station_id' => 21,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Hậu Giang -> Cần Thơ',
            //         'start_city_code' => '93',
            //         'end_city_code' => '92',
            //         'segment_number_has_hub_id' => [
            //             1 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 21,
            //                 'tmp_end_station_id' => 17,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Châu Đốc -> Cần Thơ',
            //         'start_city_code' => '89',
            //         'end_city_code' => '92',
            //         'segment_number_has_hub_id' => [
            //             2 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 9,
            //                 'tmp_end_station_id' => 12,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 12,
            //                 'tmp_end_station_id' => 17,
            //             ],
            //         ],
            //     ],
            //     [
            //         'name' => 'Cần Thơ -> Châu Đốc',
            //         'start_city_code' => '92',
            //         'end_city_code' => '89',
            //         'segment_number_has_hub_id' => [
            //             1 => 2
            //         ],
            //         'segments' => [
            //             [
            //                 'segment_number' => 1,
            //                 'tmp_start_station_id' => 17,
            //                 'tmp_end_station_id' => 12,
            //             ],
            //             [
            //                 'segment_number' => 2,
            //                 'tmp_start_station_id' => 12,
            //                 'tmp_end_station_id' => 9,
            //             ],
            //         ],
            //     ],
            // ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerData = collect($this->partnerData);

        $partnerData->each(function (array $item, int $key): void {
            $data = collect($item);

            $partnerModel = Partner::create($data->except(['phones', 'stations', 'routes'])->toArray());

            // $data->only('phone')->each(function (string $item, int $key)  use ($partnerModel) {
            //     $partnerModel->phones()->create([
            //         'phone' => $item
            //     ]);
            // });

            $phone = collect($data->get('phones'))->map(fn (string $item) => ['phone' => $item]);

            $partnerModel->phones()->createMany($phone);

            $partnerModel->wallets()->createMany([
                ['type' => 0, 'balance' => 0],
                ['type' => 1, 'balance' => 0],
                ['type' => 2, 'balance' => 0],
            ]);

            /** @var Collection<array> */
            $stationsWithId = collect();

            if ($data->has('stations')) {
                $station = array_map(
                    callback: function (array $item) {
                        $item['geography'] = Point::makeGeodetic(
                            latitude: $item['latitude'],
                            longitude: $item['longitude'],
                        );

                        // unset('tmp_id', $item);
                        unset($item['tmp_id']);

                        return $item;
                    },
                    array: $data->get('stations')
                );

                $partnerStationModels = $partnerModel->stations()->createMany($station);

                foreach ($data['stations'] as $station) {
                    $station['id'] = $partnerStationModels
                        ->where('latitude', '=', $station['latitude'])
                        ->where('longitude', '=', $station['longitude'])
                        ->first()
                        ->id;

                    $stationsWithId->push($station);
                }
            }

            if ($data->has('routes')) {
                $partnerRoutes = collect($data->get('routes'));

                $partnerRoutes->each(function (array $item) use ($partnerModel, $stationsWithId): void {
                    $partnerRoute = collect($item);

                    $partnerRouteModel = $partnerModel->routes()->create(
                        $partnerRoute->except('milestones')->merge(['package_types' => collect(PackageType::cases())])->toArray()
                    );

                    $partnerRouteMilestones = $partnerRoute->get('milestones');

                    // $partnerRouteMilestones = array_map(
                    //     callback: function (array $milestone, int $key) use ($stationsWithId) {
                    //         $milestone['station_id'] = $stationsWithId->firstWhere('tmp_id', '=', $milestone['tmp_station_id'])['id'];
                    //         $milestone['milestone_number'] = $key + 1;

                    //         unset($segment['tmp_station_id']);

                    //         return $milestone;
                    //     },
                    //     array: $partnerRouteMilestones
                    // );

                    $partnerRouteMilestones = collect($partnerRouteMilestones)->map(function (array $milestone, int $key) use ($stationsWithId) {
                        try {
                            $milestone['station_id'] = $stationsWithId->firstWhere('tmp_id', '=', $milestone['tmp_station_id'])['id'];

                        } catch (Exception) {
                            dd(
                                $stationsWithId->firstWhere('tmp_id', '=', $milestone['tmp_station_id']),
                                $stationsWithId,
                                $milestone['tmp_station_id'],
                                $milestone
                            );
                        }
                        $milestone['milestone_number'] = $key + 1;

                        unset($milestone['tmp_station_id']);

                        return $milestone;
                    })->toArray();

                    foreach ($partnerRouteMilestones as $milestone) {
                        $milestoneModel = $partnerRouteModel->milestones()->create(
                            collect($milestone)->except('hubs')->toArray()
                        );
                        if (isset($milestone['hubs'])) {
                            $milestoneModel->hubs()->attach($milestone['hubs']['id'], ['distance_from_milestone' => $milestone['hubs']['distance_from_milestone']]);
                        }
                    }
                });
            }
        });
    }
}
