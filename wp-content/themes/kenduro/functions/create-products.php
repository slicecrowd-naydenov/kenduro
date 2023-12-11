<?php
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
add_action('rest_api_init', 'add_get_products_endpoint');
$ss_ids = get_field('ss_ids', 'option');
$product_variations = array (
  'items' => 
  array (
    0 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:53:56.294000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-01T11:01:51.918000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 19,
      'ranking' => 
      array (
        'default' => 'aaaaaakvbs',
      ),
      'id' => '65250314345aa5cb9438e76d',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Carbon  Black • #019',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c37',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '6500621344784017f4ab5884',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '0',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0551',
        ),
      ),
      's3f322299d' => 'HC0551-54CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Black',
      'stth7q1i' => 
      array (
        0 => '6544e59e53629523d05e2db3',
        1 => '6544ef1021e9b8415bd53c4f',
        2 => '6544ef87149c1e2dc928989d',
        3 => '6544efb6a51b04fe6afb41ea',
        4 => '6544f84c3b825567e68e994f',
        5 => '6544f8c96e45d7aea41c9408',
        6 => '6544f92aa8af2527a1924508',
        7 => '6544fa8821bb7c3611099275',
        8 => '6544fbcd30b26412893a5e21',
        9 => '6544fc017a9efcb769e804cc',
        10 => '6548935b73b73d6f888f6a16',
        11 => '654893a5261aafaae65ec89d',
        12 => '654894800e0d2bbf41f8f698',
        13 => '6548953ebf8d21b5b31d7fc8',
        14 => '654897161b09e165c7d16b13',
        15 => '654897f158c2e8798b8a1867',
        16 => '654898ee1a11ad06c2955807',
        17 => '65489ae48261c69d2fa1c8cd',
        18 => '65489c4808bc2c95a59b524a',
        19 => '65489ef6b07c3f3baf8d8c43',
        20 => '6548a554b7c78577fe7dadb0',
        21 => '6548a66c49fba461352f8503',
        22 => '6548a66cacb93ebbcd2b4ec2',
        23 => '6548a8d867425a24c3308f7f',
        24 => '6548a8d983c138e3820539fb',
        25 => '6548ad16b8d87821fb2c5f94',
        26 => '6548ad16090d93b191dc304a',
        27 => '6548ad388d4fdb48372feeae',
        28 => '6548ad398d4fdb48372feeb0',
        29 => '6548ad65b863480b25fcee13',
        30 => '6548ad65c5dabc69a1d479b4',
        31 => '6549e353f9c5d96faa255a1c',
        32 => '6549e3a8bc0afc4fbdbaa634',
        33 => '6549e42bbe565fbebd0c4427',
        34 => '6549e8548cb0a73ee89a57a1',
        35 => '6549ea9a8b6cd46e9b9f441a',
        36 => '6549ebe852ff1166bbeab3ab',
        37 => '6549ec9ddd2a987f6cb48ac1',
        38 => '6549ee442a663842caea2483',
        39 => '6549eea4ace04bb33a165d08',
        40 => '654a045a69a0955d89735010',
        41 => '654a0a26b18372436a62f566',
        42 => '654a14746da5bf518fedce5a',
        43 => '654a14bfc2bbd6580d02e1e7',
        44 => '654a15378827ebb562e1f488',
        45 => '654a15875fac2138819b2015',
        46 => '654a258f311c397ca9a4a749',
        47 => '654a25d4cb4c7856bd09c99a',
        48 => '654a2634cda8de3f4a80816c',
        49 => '654b456043e203606b72174b',
        50 => '654b47bc904cbd653fc9b066',
        51 => '654b5be4879f8b07d2f591db',
        52 => '654b62761db6797176703100',
        53 => '654b635abc93f33455633c24',
        54 => '654b63a79291c6d05461889b',
        55 => '654b6484d3240a77f6b30958',
        56 => '654b65c71bae7ca25ae06a73',
        57 => '654b66807f39904852f70be7',
        58 => '654b85b67385c0662a155c1b',
        59 => '65549036c0efe59637ff2635',
        60 => '655498ec5182c8b8e390f010',
        61 => '655498f3f26fddb0fc192361',
        62 => '655498fa8d9369b24daf6fac',
        63 => '655498fee9f8ae6bdd640c23',
        64 => '6554990030bea905c6288559',
        65 => '65549904b5ba02901cfd59f2',
        66 => '65549906436f1740b76a32d5',
        67 => '6554990a3b7f60a2c385428c',
        68 => '6554990d436f1740b76a32d7',
        69 => '65549910db18eff5d588536c',
        70 => '65549913ebaa661fa9154f64',
        71 => '65549917f26fddb0fc192366',
        72 => '65549919488beb07f5ea2265',
        73 => '6554991d30bea905c628855b',
        74 => '65549920bf11c9d7bb107cc6',
        75 => '655499233b7f60a2c385428e',
        76 => '655499265182c8b8e390f012',
        77 => '65549929c6fbe3fb3ee3df28',
        78 => '6554992c7c72ba7aa54ca219',
        79 => '6554992f3feb763d5a50153f',
        80 => '65549932c6fbe3fb3ee3df2a',
        81 => '655499360ebd5c2b31e22c3c',
        82 => '655499383feb763d5a501542',
        83 => '6554993c55797da6cee48a42',
        84 => '6554993e0ebd5c2b31e22c3e',
        85 => '655499431e6fd64b3aa517ef',
        86 => '65549944ebaa661fa9154f67',
        87 => '65549948bf11c9d7bb107ccc',
        88 => '6554994a0e3fdf59b0d55934',
        89 => '6554994f4cdceb08d6030236',
        90 => '655499510d876b92b28fe35b',
        91 => '65549955436f1740b76a32e9',
        92 => '65549958e9f8ae6bdd640c25',
        93 => '6554995c1e6fd64b3aa517f1',
        94 => '6554995fbf11c9d7bb107d20',
        95 => '65549963a3014d3b26b01e31',
        96 => '65549965b8d040414aea9c62',
        97 => '655499693b7f60a2c3854291',
        98 => '6554996c4216cc57f40da56a',
        99 => '6554996fc45e5de7ccabb5d1',
        100 => '65549973a795ebc5a853d83e',
        101 => '65549976db18eff5d588539b',
        102 => '65549b36d7b17da24603b87f',
        103 => '65549c04b76f770fea7897f7',
        104 => '65549c71c691d269e2a9b744',
        105 => '65549c9abb6dd56f53eed505',
        106 => '6554a258a7f0f10c22cb46ff',
        107 => '6554a2cfb6d8c5bc272669cb',
        108 => '6554a4018417b96bac531171',
        109 => '6554c0236e10ebfef1822fdd',
        110 => '6555bf20a6a1820d223b5acb',
        111 => '6555c847c696cea1cff9bb37',
        112 => '6555c9cfd01ec141ca6dc139',
        113 => '6555cf33490e8188ebd39cb4',
        114 => '6555d05977977c22a1e107ae',
        115 => '6555d17a22582510b66d61ad',
        116 => '6555d1f45e04edc2118be1bb',
        117 => '6555d3328ea49a19c2070632',
        118 => '6555d39b3a0dbb69b3642ea6',
        119 => '6555d41c69378b1892d952a3',
        120 => '6555d47a1ceecb17caf902dc',
        121 => '6555d4e07db9803791c08c51',
        122 => '6555dd35c02eb8ea0dba3f54',
        123 => '6555de05c992d9aee745bd9b',
        124 => '6555de73d0f69c19e5668caa',
        125 => '6555f9c415446019e6fcf6ab',
        126 => '655612f08cad50b68a3fd97c',
        127 => '655613929ad4decdac9a5713',
        128 => '655613bac1004d20c43f3ded',
        129 => '655617d6a82c3dac8ac1167b',
        130 => '65561ebd0c1fe87e99dca2ef',
        131 => '65561f2e1c06efa65b308d54',
        132 => '65571a4fbd3c1cee9277137d',
        133 => '65571a7b91ebaa6b9ec2af7d',
        134 => '65571a98b0052792fe79b2af',
        135 => '65574bca07020842e0467a8d',
        136 => '65574bfaa82696dfaab79327',
        137 => '65574c10e8834bcfd1fc5467',
        138 => '65575062268e5c10c2b5e677',
        139 => '65575089070d8cad116c6513',
        140 => '65575219025ffe1249362fe7',
        141 => '655c66fe3b19ee600407f447',
        142 => '655c684708c09236fb9fb0a3',
        143 => '655c68946c19582513c985ec',
      ),
      's6cf281f60' => '65250314345aa5cb9438e76d',
      's5aac89d68' => '202',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '242.4',
    ),
    1 => 
    array (
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'ranking' => 
      array (
        'default' => 'aaaaaaljwi',
        '651f9c5bf5b14e0d99b3e73d' => 'aaaaaalcma',
      ),
      'autonumber' => 20,
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:54:02.478000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-01T07:09:15.005000Z',
      ),
      'id' => '6525031a8ee179f55df50afd',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Carbon  Black • #020',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c37',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '65006216b2487833af5099ba',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '8',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0551',
        ),
      ),
      's3f322299d' => 'HC0551-56CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Black',
      'stth7q1i' => 
      array (
        0 => '6548af30c4904e0b956aaeb1',
        1 => '6548b14f0b416a6db61cfd80',
        2 => '6549e3534176a0dbc91e70e4',
        3 => '6549e3a8c757d44308aae3c1',
        4 => '6549e42b2ea0133508caa51f',
        5 => '6549e5fbfd4aa7f1cfc267f5',
        6 => '6549e854d209116d47cb716a',
        7 => '6549ea9a14bbac5c4c03b9e8',
        8 => '6549ebe8c37b4dd4bae910ad',
        9 => '6549ec9d115c76119ced8aac',
        10 => '6549ee44ad6039f9a4ecfb2b',
        11 => '6549eea435991a0b04f4d756',
        12 => '654a1d66a8119f45181deaf4',
        13 => '654a27a76dd8448f83179278',
        14 => '654b8fcf37a72f69bd49d87e',
        15 => '654c8b99b20eb5afb862b217',
        16 => '654c8bda0833f1a2a5dff9e5',
        17 => '654c8c6fda6d14f1d1b0e591',
        18 => '654c9c2b560d6fb2a78fef69',
        19 => '654ca1c37867bba67eb3d83e',
        20 => '654ca4de7f04a466046577d8',
        21 => '654ca8307087b2e16b03c651',
        22 => '6551c6861f2d8ce4674d3938',
        23 => '6551ca411442a0db9e37775a',
        24 => '6551cc29650ebe11191e2248',
        25 => '6551cdc79c35ba09ab2d8d51',
        26 => '6551f4d82272d03eb2f63a0a',
        27 => '65533acbad00382bfb5aee47',
        28 => '65534627493932a1e8790294',
        29 => '6554bedc97f4b9875c8328bc',
        30 => '6554bf197d781c6948642394',
        31 => '6554bf4ab17a07dc516ce97c',
        32 => '6554bfa9c52ce59923b08e9e',
        33 => '6554bfd8af1a159c0026bb8e',
        34 => '6554c005f1b4d6fceba6c208',
        35 => '6554c9fc19256155f3d2bd55',
        36 => '6555be3d10341c74419f7936',
        37 => '6555bf20a6a1820d223b5acc',
        38 => '6555c847c696cea1cff9bb38',
        39 => '6555c9cfd01ec141ca6dc13a',
        40 => '6555cf33490e8188ebd39cb5',
        41 => '6555d05977977c22a1e107af',
        42 => '6555d17a22582510b66d61ae',
        43 => '6555d1f45e04edc2118be1bc',
        44 => '6555d3328ea49a19c2070633',
        45 => '6555d39b3a0dbb69b3642ea7',
        46 => '6555d41c69378b1892d952a4',
        47 => '6555d47a1ceecb17caf902dd',
        48 => '6555d4e07db9803791c08c52',
        49 => '6555d52d565a31802ee94a44',
        50 => '6555dd35c02eb8ea0dba3f55',
        51 => '6555de05c992d9aee745bd9c',
        52 => '6555f914db7ad3517814275e',
        53 => '6555feecdd453262024b45e8',
        54 => '65561a48e2c7609c82f66073',
        55 => '65561ebd0c1fe87e99dca2f0',
        56 => '65561f2e1c06efa65b308d55',
        57 => '65571a4fbd3c1cee9277137e',
        58 => '65571a7b91ebaa6b9ec2af7e',
        59 => '65571a98b0052792fe79b2b0',
        60 => '65574ae73dbb51b9a3f778c8',
        61 => '65574b3d8c39c9f739ff9475',
        62 => '65574c45e1f2b7313cb7a569',
        63 => '65574c6bade86d8dc82d1462',
        64 => '65574c873296db7887e14f4d',
        65 => '65575062268e5c10c2b5e678',
        66 => '65575089070d8cad116c6514',
        67 => '65575219025ffe1249362fe8',
        68 => '655c684708c09236fb9fb0a4',
        69 => '655c68946c19582513c985ed',
      ),
      's6cf281f60' => '6525031a8ee179f55df50afd',
      's5aac89d68' => '78',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '93.6',
    ),
    2 => 
    array (
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'ranking' => 
      array (
        'default' => 'aaaaaalyqy',
        '651f9c5bf5b14e0d99b3e73d' => 'aaaaaaljwi',
      ),
      'autonumber' => 21,
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:54:14.501000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-30T08:50:02.460000Z',
      ),
      'id' => '6525032642b07b7b01120217',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Carbon  Black • #021',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c37',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '65006219c02f7fd74256e4f4',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '11',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0551',
        ),
      ),
      's3f322299d' => 'HC0551-58CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Black',
      'stth7q1i' => 
      array (
        0 => '6544ef1021e9b8415bd53c4f',
        1 => '6544ef87149c1e2dc928989d',
        2 => '6549e354fd4aa7f1cfc267ec',
        3 => '6549e3a8b3d85db7a9dddb11',
        4 => '6549e42becec4f5d81e327db',
        5 => '6549e5fb8cb0a73ee89a5784',
        6 => '6549e854a706191c35b36e1c',
        7 => '6549ea9aadc5137624fcf6e2',
        8 => '6549ebe9d00db32c6fc46185',
        9 => '6549ec9cbbff358d57b7fc73',
        10 => '6549ee44b5d6da07cc483b37',
        11 => '6549eea44b4bce5133b8afa1',
        12 => '654c9c2b560d6fb2a78fef6a',
        13 => '654ca1c37867bba67eb3d83f',
        14 => '654ca4de7f04a466046577d9',
        15 => '654ca8307087b2e16b03c652',
        16 => '6551c34a0961309373db670a',
        17 => '6551c43062f68397b5ab5380',
        18 => '6551caac72a5f10340a661f9',
        19 => '6551cb1dc8762f46a6601a0e',
        20 => '6551f4d82272d03eb2f63a0b',
        21 => '65521d8808d4684f3b7ab7a4',
        22 => '65521db014c2f568aea67976',
        23 => '65533acbad00382bfb5aee48',
        24 => '65534627493932a1e8790295',
        25 => '6554bedc97f4b9875c8328bd',
        26 => '6554bf197d781c6948642395',
        27 => '6554bf4ab17a07dc516ce97d',
        28 => '6554bfa9c52ce59923b08e9f',
        29 => '6554bfd8af1a159c0026bb8f',
        30 => '6554c9fc19256155f3d2bd56',
        31 => '6555be134dd7fd511d06ac5b',
        32 => '65571a4fbd3c1cee92771384',
        33 => '65571a7b91ebaa6b9ec2af84',
        34 => '65571a98b0052792fe79b2b6',
        35 => '65574949fbcdcbeaf95eb768',
        36 => '65575062268e5c10c2b5e679',
        37 => '65575089070d8cad116c6515',
        38 => '65575219025ffe1249362fe9',
      ),
      's6cf281f60' => '6525032642b07b7b01120217',
      's5aac89d68' => '306',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '367.2',
    ),
    3 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:54:35.775000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-20T12:46:48.702000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 22,
      'ranking' => 
      array (
        'default' => 'aaaaaamnlo',
      ),
      'id' => '6525033bb597c239f55137be',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска MX Stratos Fibra  Orange • #022',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c38',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '6500621c2722d6722e5941cb',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '0',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0531',
        ),
      ),
      's3f322299d' => 'HC0531-60CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Orange',
      'stth7q1i' => 
      array (
        0 => '6548b564b400ab68fb7c9a53',
        1 => '6548b565b000d37daf4f520c',
        2 => '6548c31eb2d65172bd2b1f05',
        3 => '6548c31e5e253bb235135d7e',
        4 => '654a045ac7d3ce329e28020a',
        5 => '654a0a26b18372436a62f564',
        6 => '654a1474c2bbd6580d02e1e2',
        7 => '654a14bf4844ad473dab7951',
        8 => '654a1536fbd8c9fc7d6c58b0',
        9 => '654a15888065b26a52b30dc8',
        10 => '654a258fce1c4f009504a607',
        11 => '654a25d36f0d24f534f31a67',
        12 => '654a2634478557e086c4ff5a',
        13 => '654b332c18e18aea556fccb2',
        14 => '654b34955059751dd22a2af9',
        15 => '654b350badb2c1b603a2583d',
        16 => '654b3bc88d07ad7fd8e8b3d6',
        17 => '654b3bf1e634208e02d8f1cc',
        18 => '654b3c03a20b17485e4cbb18',
        19 => '654b3c7eaabb546b074af26d',
        20 => '654b3cea987819623de40b2e',
        21 => '654b3f1f9644954a6d091904',
        22 => '654b3f745974c7ef1c0e52fa',
        23 => '654b3f81bdd8ebddd6208d20',
        24 => '654b3faa2432ac13fedad0e2',
        25 => '654b40dc5974c7ef1c0e8c7f',
        26 => '654b43deac8d86d8e2f3efe3',
        27 => '654b44288e164d644b16f295',
        28 => '654b44bba9f485a59d19668b',
        29 => '654b451669287c5ad635c4dd',
        30 => '654b456055ac2ef89338f661',
        31 => '654b47bc8129faef9f986fc7',
        32 => '654b5be45ae3b06981f3a89c',
        33 => '654e369817c89f02909bfd2f',
        34 => '65561c6022b6b85671c39ed8',
        35 => '65561d790f1933ba2288cce2',
        36 => '65561ebd0c1fe87e99dca2ec',
        37 => '65561f2e1c06efa65b308d51',
      ),
      's6cf281f60' => '6525033bb597c239f55137be',
      's5aac89d68' => '19',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '22.8',
    ),
    4 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:55:18.447000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-20T12:46:48.865000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 23,
      'ranking' => 
      array (
        'default' => 'aaaaaancge',
      ),
      'id' => '652503660ffd92bee4bc9b10',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Heritage Matt  Matt • #023',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c39',
      ),
      'sw8k35i5' => 
      array (
        0 => '6500607050a026611cc00d02',
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '4',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0532',
        ),
      ),
      's3f322299d' => 'HC0532-S',
      'sde6d004da' => 'pa_650058cb3c5d9cebee294e3e',
      'sd2ffdf417' => 'Matt',
      'stth7q1i' => 
      array (
        0 => '654a2e6ccb35eb8bce1e3662',
        1 => '654a33e926fbb39a6e8a3f28',
        2 => '654a3406126842e36eb21d18',
        3 => '654a36c74766959f166eb1a5',
        4 => '654a3a22c61dff5f32e60095',
        5 => '654a3ae43aeb5986c9d4847e',
        6 => '654a3af7bba00c6d37affcb4',
        7 => '654a3d7be9e4bbcb1aeefe50',
        8 => '654b327d2590b06c3ee8856c',
        9 => '654b332cf93635fd740994c2',
        10 => '6555bf20a6a1820d223b5acd',
        11 => '6555c847c696cea1cff9bb39',
        12 => '6555c9cfd01ec141ca6dc13b',
        13 => '6555cf33490e8188ebd39cb6',
        14 => '6555d05977977c22a1e107b0',
        15 => '6555d17a22582510b66d61af',
        16 => '6555d1f45e04edc2118be1bd',
        17 => '6555d3328ea49a19c2070634',
        18 => '6555d39b3a0dbb69b3642ea8',
        19 => '6555d41c69378b1892d952a5',
        20 => '6555d47a1ceecb17caf902de',
        21 => '6555d4e07db9803791c08c53',
        22 => '6555dd35c02eb8ea0dba3f56',
        23 => '6555de05c992d9aee745bd9d',
        24 => '6555de73d0f69c19e5668cab',
        25 => '65561a48e2c7609c82f66074',
        26 => '65571a4fbd3c1cee92771382',
        27 => '65571a7b91ebaa6b9ec2af82',
        28 => '65571a98b0052792fe79b2b4',
        29 => '65574d28368038b92b1ae9be',
        30 => '65574d5596faeaeaaac197d1',
        31 => '65574ecbbc38c925b02d7778',
      ),
      's6cf281f60' => '652503660ffd92bee4bc9b10',
      's5aac89d68' => '199',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '238.8',
    ),
    5 => 
    array (
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'ranking' => 
      array (
        'default' => 'aaaaaanrau',
        '651f9c5bf5b14e0d99b3e73d' => 'aaaaaanjqm',
      ),
      'autonumber' => 24,
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:55:26.153000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:04:58.277000Z',
      ),
      'id' => '6525036eac821a5abebd78a5',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Heritage Matt  Matt • #024',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c39',
      ),
      'sw8k35i5' => 
      array (
        0 => '65006074750fd5b061f5f2b3',
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '0',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0532',
        ),
      ),
      's3f322299d' => 'HC0532-M',
      'sde6d004da' => 'pa_650058cb3c5d9cebee294e3e',
      'sd2ffdf417' => 'Matt',
      'stth7q1i' => 
      array (
        0 => '654e3710d04f740633c7a805',
        1 => '654e3867109fbc6a4dcb4c76',
        2 => '65571a4fbd3c1cee92771383',
        3 => '65571a7b91ebaa6b9ec2af83',
        4 => '65571a98b0052792fe79b2b5',
        5 => '65574d28368038b92b1ae9bf',
        6 => '65574d5596faeaeaaac197d2',
        7 => '65574ecbbc38c925b02d7779',
      ),
      's6cf281f60' => '6525036eac821a5abebd78a5',
      's5aac89d68' => '85',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '102.0',
    ),
    6 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-10T07:59:51.868000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-20T12:46:49.194000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 25,
      'ranking' => 
      array (
        'default' => 'aaaaaaofvk',
      ),
      'id' => '65250477198d894d58911adb',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Stage III  White • #025',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3b',
      ),
      'sw8k35i5' => 
      array (
        0 => '6500607050a026611cc00d02',
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '6',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0629',
        ),
      ),
      's3f322299d' => 'HC0629-S',
      'sde6d004da' => 'pa_650058cb3c5d9cebee294e3e',
      'sd2ffdf417' => 'White',
      'stth7q1i' => 
      array (
        0 => '6554c54d97663bd0a53265a5',
        1 => '6554c66d52d0234bc096e49a',
        2 => '6554c7a24938f057ab2db0a3',
        3 => '6554c8c8ee5de1bb5dcb099f',
        4 => '6554c9df53c0addca21f78b0',
        5 => '6554caa542c76e6ba58ffe2e',
        6 => '6555bf20a6a1820d223b5ace',
        7 => '6555c847c696cea1cff9bb3a',
        8 => '6555c9cfd01ec141ca6dc13c',
        9 => '6555cf33490e8188ebd39cb7',
        10 => '6555d05977977c22a1e107b1',
        11 => '6555d17a22582510b66d61b0',
        12 => '6555d1f45e04edc2118be1be',
        13 => '6555d3328ea49a19c2070635',
        14 => '6555d39b3a0dbb69b3642ea9',
        15 => '6555d41c69378b1892d952a6',
        16 => '6555d47a1ceecb17caf902df',
        17 => '6555d4e07db9803791c08c54',
        18 => '6555d6570eaf6bcf55834057',
        19 => '6555dd35c02eb8ea0dba3f57',
        20 => '6555de05c992d9aee745bd9e',
        21 => '65561c6022b6b85671c39ed9',
        22 => '65561d790f1933ba2288cce3',
        23 => '65561ebd0c1fe87e99dca2ee',
        24 => '65561f2e1c06efa65b308d53',
        25 => '65571a4fbd3c1cee92771381',
        26 => '65571a7b91ebaa6b9ec2af81',
        27 => '65571a98b0052792fe79b2b3',
        28 => '65572f759d63c7599d5b3417',
        29 => '65572f8a377880a4cbbad6d0',
      ),
      's6cf281f60' => '65250477198d894d58911adb',
      's5aac89d68' => '190',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '228.0',
    ),
    7 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-11T09:03:06.775000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-20T12:46:49.432000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 26,
      'ranking' => 
      array (
        'default' => 'aaaaaaouqa',
      ),
      'id' => '652664cad08a33e1699ffe3e',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Ръкавици Baggy II • #026',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c41',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '0',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HE1129',
        ),
      ),
      's3f322299d' => 'HE1129',
      'sde6d004da' => '',
      'sd2ffdf417' => '',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '652664cad08a33e1699ffe3e',
      's5aac89d68' => '90',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '108.0',
    ),
    8 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-12T06:02:47.435000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-01T07:10:29.093000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 28,
      'ranking' => 
      array (
        'default' => 'aaaaaapyfg',
      ),
      'id' => '65278c07fde1f03c6c9cf763',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Brain  Red • #028',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3e',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '6500620c2022ec9cb56716d8',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '9',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0626',
        ),
      ),
      's3f322299d' => 'HC0626-52CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Red',
      'stth7q1i' => 
      array (
        0 => '6544e2c9674cf1c6378edeef',
        1 => '6544e3dd78259b30c752ab76',
        2 => '6544e42a91bc4f27cf7a1389',
        3 => '6544e46fcb7386f8aa218b48',
        4 => '6544e4bfcbc6ab7e3f9b9f8d',
        5 => '6549f00aad6039f9a4ecfb34',
        6 => '6549f125e583b9666780f914',
        7 => '6549f55a6ee6c400f034b949',
        8 => '6549f5b517b889ccc813fbd4',
        9 => '6549f634c1f11e6ca73130a3',
        10 => '6549f68cb207d6406aee51f0',
        11 => '6549f6db91fe344078ffb8a7',
        12 => '6549f81d6228b95eafffe346',
        13 => '654a008b04d8aa82f8c5193a',
        14 => '654a01e53a2bfd9d9b8f5c88',
        15 => '654a1d0335415e44674cda9a',
        16 => '654a258f2bd929f0e06e4038',
        17 => '654a25d3ee0bf6d6f392731d',
        18 => '654a2634478557e086c4ff58',
        19 => '654a27a76dd8448f83179278',
        20 => '654a2a09dfcadf49f77a6c7e',
        21 => '654a2a17b6019f6b71b8e937',
        22 => '654a2a44123bfe4acfdebc9e',
        23 => '654a2aa340ae471bb673b136',
        24 => '654a2b3e328c91dc1eb75e15',
        25 => '654a2b6c2f593aa2c5836ed8',
        26 => '654a2b99f8a9379a97f8d26c',
        27 => '654a3407f3c9bda6ca83cf57',
        28 => '654a36c750f6d46a1a31233e',
        29 => '654a3a23ce19bbc40d2947ca',
        30 => '654a3ae3cd6ad0b67001e16b',
        31 => '654a3af7126e765c374ad2fd',
        32 => '654a3d7c458333728de351ba',
        33 => '654b2d948686d7c42d8e44f2',
        34 => '654b327d0a8f8209c28cf348',
        35 => '654b332bf614d33e69ee8a59',
        36 => '654b6777015877611d924366',
        37 => '654b68adf2c45252418bbd7b',
        38 => '654b68adf2c45252418bbd7c',
        39 => '654b690ae465cfe80d08e08b',
        40 => '654b690ae465cfe80d08e08c',
        41 => '654b8310579e1f76b531e307',
        42 => '654c8b99b20eb5afb862b218',
        43 => '654c8bda0833f1a2a5dff9e6',
        44 => '654c8c6fda6d14f1d1b0e592',
        45 => '654c8d8df13085d69692622d',
        46 => '654c8f4604a5feab6c184a0f',
        47 => '654c8f6db20eb5afb862b3b0',
        48 => '654c8fd0e3ed219d6beed4ee',
        49 => '654c9011dcfb7a184e72fbe2',
        50 => '654c90e9ba28462ea07c2e55',
        51 => '654c91c5bef75816eee0fcf2',
        52 => '654c9203913d52f3289fd1f5',
        53 => '654c922a88bc1234ad76a2e5',
        54 => '654c92646bc04f3d57766d5d',
        55 => '654c929b93597b0329fcb3d4',
        56 => '654c93565c1abaaa1dff4801',
        57 => '654c93ff4bc17d4b9bf46cd5',
        58 => '654c977bea596366a6a83707',
        59 => '654e2f7b9035612482576aaf',
        60 => '6555f40730c506704449542f',
        61 => '65571a4fbd3c1cee92771380',
        62 => '65571a7b91ebaa6b9ec2af80',
        63 => '65571a98b0052792fe79b2b2',
        64 => '65574cbf190a220332272eb9',
        65 => '65574d28368038b92b1ae9bc',
        66 => '65574d5596faeaeaaac197cf',
        67 => '65574ecbbc38c925b02d7776',
        68 => '65575219025ffe1249362fea',
      ),
      's6cf281f60' => '65278c07fde1f03c6c9cf763',
      's5aac89d68' => '87',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '104.4',
    ),
    9 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-12T06:53:33.976000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-11T12:16:48.436000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 29,
      'ranking' => 
      array (
        'default' => 'aaaaaaqmzw',
      ),
      'id' => '652797ed93d2f48642ca6d10',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Jail  Black • #029',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3a',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '9',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0536',
        ),
      ),
      's3f322299d' => 'HC0536',
      'sde6d004da' => '',
      'sd2ffdf417' => 'Black',
      'stth7q1i' => 
      array (
        0 => '654c8c6fda6d14f1d1b0e593',
        1 => '654c8cad5c312316bb343963',
        2 => '654c8cf749a13621c6a1a247',
        3 => '654c8d8df13085d69692622c',
        4 => '654c8f4604a5feab6c184a0e',
        5 => '654c8f6db20eb5afb862b3af',
        6 => '654c8fd0e3ed219d6beed4ed',
        7 => '654c9011dcfb7a184e72fbe1',
        8 => '654c90e9ba28462ea07c2e54',
        9 => '654c91c5bef75816eee0fcf1',
        10 => '654c9203913d52f3289fd1f4',
        11 => '654c922a88bc1234ad76a2e4',
        12 => '654c92646bc04f3d57766d5c',
        13 => '654c93565c1abaaa1dff4802',
        14 => '654c93ff4bc17d4b9bf46cd6',
        15 => '654e34727c845db384cd6c85',
        16 => '65533acbad00382bfb5aee49',
        17 => '65534627493932a1e8790296',
        18 => '6554bedc97f4b9875c8328be',
        19 => '6554bf197d781c6948642396',
        20 => '6554bf4ab17a07dc516ce97e',
        21 => '6554bfa9c52ce59923b08ea0',
        22 => '6554bfd8af1a159c0026bb90',
        23 => '6554c03cc0fecddcda3383fe',
        24 => '6554c319dfce10fcc3e64d49',
        25 => '6554c9fc19256155f3d2bd57',
        26 => '6555bed5683200f97937dc23',
        27 => '6555bf20a6a1820d223b5acf',
        28 => '6555c847c696cea1cff9bb3b',
        29 => '6555c9cfd01ec141ca6dc13d',
        30 => '6555cf33490e8188ebd39cb8',
        31 => '6555d05977977c22a1e107b2',
        32 => '6555d17a22582510b66d61b1',
        33 => '6555d1f45e04edc2118be1bf',
        34 => '6555d3328ea49a19c2070636',
        35 => '6555d39b3a0dbb69b3642eaa',
        36 => '6555d41c69378b1892d952a7',
        37 => '6555d47a1ceecb17caf902e0',
        38 => '6555d4e07db9803791c08c55',
        39 => '6555d59891e065bf15dfda3a',
        40 => '6555d5b002d88f6c272ca579',
        41 => '6555daa83cd85e113483ea5e',
        42 => '6555dd35c02eb8ea0dba3f58',
        43 => '6555de05c992d9aee745bd9f',
        44 => '6555de73d0f69c19e5668cac',
        45 => '655612f08cad50b68a3fd97d',
        46 => '655613929ad4decdac9a5714',
        47 => '655613bac1004d20c43f3dee',
        48 => '655617d6a82c3dac8ac1167c',
        49 => '65571a4fbd3c1cee9277137f',
        50 => '65571a7b91ebaa6b9ec2af7f',
        51 => '65571a98b0052792fe79b2b1',
        52 => '655c684708c09236fb9fb0a5',
        53 => '655c68946c19582513c985ee',
      ),
      's6cf281f60' => '652797ed93d2f48642ca6d10',
      's5aac89d68' => '22',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '26.4',
    ),
    10 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-20T11:36:11.518000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-20T12:46:49.774000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 30,
      'ranking' => 
      array (
        'default' => 'aaaaaarbum',
      ),
      'id' => '6532662bbefcd5d8e28db3a7',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска MX Ransom Fibra  Blue • #030',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c36',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '11',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0529',
        ),
      ),
      's3f322299d' => 'HC0529',
      'sde6d004da' => '',
      'sd2ffdf417' => 'Blue',
      'stth7q1i' => 
      array (
        0 => '6548b564b400ab68fb7c9a53',
        1 => '6548b565b000d37daf4f520c',
        2 => '6548c31eb2d65172bd2b1f05',
        3 => '6548c31e5e253bb235135d7e',
        4 => '6549ec9cad6039f9a4ecfb25',
        5 => '6549ee44ccf5af30fc402958',
        6 => '6549eea4115c76119ced8abc',
        7 => '654a045a74ff8693a9d319f9',
        8 => '654a0a26e9b248b5a6f83759',
        9 => '654a147427447643a2b90a3f',
        10 => '654a14bf4844ad473dab7953',
        11 => '654a15375b43014992a01f83',
        12 => '654a158884bcf093f05fd6f1',
        13 => '654a258f478557e086c4ff53',
        14 => '654a25d45e957bad22deafa5',
        15 => '654a263412ccc2a9eee0e621',
        16 => '65561a49e2c7609c82f66075',
        17 => '65561ebd0c1fe87e99dca2ed',
        18 => '65561f2e1c06efa65b308d52',
        19 => '65574d28368038b92b1ae9bd',
        20 => '65574d5596faeaeaaac197d0',
        21 => '65574ecbbc38c925b02d7777',
        22 => '6557501376f3a00b617e1d72',
        23 => '65575062268e5c10c2b5e676',
        24 => '65575089070d8cad116c6512',
      ),
      's6cf281f60' => '6532662bbefcd5d8e28db3a7',
      's5aac89d68' => '333',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '399.6',
    ),
    11 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-10-20T11:39:35.265000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T12:20:52.580000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 32,
      'ranking' => 
      array (
        'default' => 'aaaaaasfjs',
      ),
      'id' => '653266f771e799e692c2415d',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска MX Ransom Fibra test  Blue • #032',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '653265d6cc1d30f0fd502ac2',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '65006216b2487833af5099ba',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '4',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0529',
        ),
      ),
      's3f322299d' => 'HC0529-56CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Blue',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '653266f771e799e692c2415d',
      's5aac89d68' => '600',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '720.0',
    ),
    12 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T07:00:08.082000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:04:43.852000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 33,
      'ranking' => 
      array (
        'default' => 'aaaaaasuei',
      ),
      'id' => '655c557872e1f3d4bef64d0f',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Очила Gravity II  Grey • #033',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3f',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '6',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC2003',
        ),
      ),
      's3f322299d' => 'HC2003',
      'sde6d004da' => '',
      'sd2ffdf417' => 'Grey',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '655c557872e1f3d4bef64d0f',
      's5aac89d68' => '9',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '10.8',
    ),
    13 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T07:03:40.163000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:04:50.054000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 35,
      'ranking' => 
      array (
        'default' => 'aaaaaatxto',
      ),
      'id' => '655c564cdcbae366daeeb680',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo ОчилаQuantum II  Matt • #035',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c40',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '8',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC2003',
        ),
      ),
      's3f322299d' => 'HC2003',
      'sde6d004da' => '',
      'sd2ffdf417' => 'Matt',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '655c564cdcbae366daeeb680',
      's5aac89d68' => '57',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '68.4',
    ),
    14 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:10:43.110000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64e2ff40e3c90fc88a5feb78',
        'on' => '2023-11-21T12:53:00.285000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 36,
      'ranking' => 
      array (
        'default' => 'aaaaaaumoe',
      ),
      'id' => '655c660308de91996b137c2c',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Heritage  Red • #036',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3c',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '6500621344784017f4ab5884',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '8',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0533',
        ),
      ),
      's3f322299d' => 'HC0533-54CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Red',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '655c660308de91996b137c2c',
      's5aac89d68' => '46',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '55.2',
    ),
    15 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:11:04.969000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:12:57.512000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 37,
      'ranking' => 
      array (
        'default' => 'aaaaaavbiu',
      ),
      'id' => '655c66183b19ee600407f443',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска Heritage  Red • #037',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3c',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
        0 => '6500621c2722d6722e5941cb',
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '5',
      's85435bce7' => 'Yes',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0533',
        ),
      ),
      's3f322299d' => 'HC0533-60CM',
      'sde6d004da' => 'pa_650058ebd93eaa4d39a0a26b',
      'sd2ffdf417' => 'Red',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '655c66183b19ee600407f443',
      's5aac89d68' => '49',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '58.8',
    ),
    16 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-21T08:11:29.135000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-11-27T12:45:45.393000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 38,
      'ranking' => 
      array (
        'default' => 'aaaaaavqdk',
      ),
      'id' => '655c6631c7fea0bf90656a16',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hebo Каска MX Maddock II Fibra  Black • #038',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60c3d',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '9',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HC0535',
        ),
      ),
      's3f322299d' => 'HC0535',
      'sde6d004da' => '',
      'sd2ffdf417' => 'Black',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '655c6631c7fea0bf90656a16',
      's5aac89d68' => '82',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '98.4',
    ),
    17 => 
    array (
      'first_created' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-01T07:02:11.537000Z',
      ),
      'last_updated' => 
      array (
        'by' => '64fffc68ecc0f5c4c47aae69',
        'on' => '2023-12-01T07:06:52.732000Z',
      ),
      'application_id' => '651f9c5af5b14e0d99b3e73c',
      'autonumber' => 40,
      'ranking' => 
      array (
        'default' => 'aaaaaawtsq',
      ),
      'id' => '656984f34a64bb069ca5ac2a',
      'application_slug' => 's9rb62gs',
      'deleted_date' => 
      array (
        'date' => NULL,
      ),
      'title' => 'Hiflo Oil Filter • #040',
      'comments_count' => 0,
      'followed_by' => 
      array (
      ),
      's58a540161' => 
      array (
        0 => '64fffa49372b0c1543d60cf0',
      ),
      'sw8k35i5' => 
      array (
      ),
      's6g88evh' => 
      array (
      ),
      'swk3pror' => 
      array (
      ),
      'suhvfzhr' => 
      array (
      ),
      's0ecfcadaf' => '7',
      's85435bce7' => 'No',
      's144bdc8ca' => 
      array (
        0 => 
        array (
          0 => 'HF141',
        ),
      ),
      's3f322299d' => 'HF141',
      'sde6d004da' => '',
      'sd2ffdf417' => '',
      'stth7q1i' => 
      array (
      ),
      's6cf281f60' => '656984f34a64bb069ca5ac2a',
      's5aac89d68' => '37',
      's04e79cf46' => false,
      'se2f301dda' => '100',
      's4077f47b6' => '44.4',
    ),
  ),
  'total' => 18,
  'offset' => 0,
  'limit' => 0,
  'time' => '2023-12-11T13:07:45.644369Z',
);

function add_get_products_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-products/(?P<id>[^/]+)(?:/(?P<product_id>[^/]+))?',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_products',
      'permission_callback' => function () {
        return true;
      }
    )
  );
}

function get_all_products($request) {
  global $product_variations, $fieldsToRemove, $ss_ids;

  $data = $request->get_json_params();
  $id = $request->get_param('id');
  $product_id = $request->get_param('product_id');
  $external_api_response = get_external_api_response($id, $data);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);  
  $product_variation = get_column_field_id('product_variation', $product_variations_fields);
  $outputArray = array();

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }
  
  foreach ($product_variations['items'] as $variation) {
    if (isset($variation[$product_variation]) && is_array($variation[$product_variation])) {
      foreach ($variation[$product_variation] as $value) {
        if (!in_array($value, $outputArray)) {
          $outputArray[] = $value;
        }
      }
    }
  }

  $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

  $filteredArrays = array_filter($filteredData, function ($item) use ($outputArray) {
    return in_array($item['id'], $outputArray);
  });

  if (!$product_id) {
    // Create product
    create_woocommerce_products($filteredArrays);
  } else {
    // Update product
    $filteredArrays = array_filter($filteredData, function ($item) use ($product_id) {
      return $item['id'] === $product_id;
    });
    update_woocommerce_product($filteredArrays, $product_id);
  }

  return $filteredArrays;
}

function is_variation_id($id) {
  $result = 0;
  $arr = array(
    'post_type'       => 'product_variation',
    'post_status'     => 'publish',
    'posts_per_page'  => -1,
    'meta_query'      => array(
      'relation'    => 'AND',
      array(
        'key'     => '_my_product_variation_id',
        'value'   => $id,
        'compare' => '='
      )
    ),
  );

  $q = new WP_Query( $arr );

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }
  wp_reset_postdata();

  return $result;
}

function is_product_id($id) {
  $result = 0;

  $arr = array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'meta_query'    => array(
      'relation'      => 'AND',
      array(
        'key'       => 'meta_data_$_key',
        'compare'   => '=',
        'value'     => 'product_variation_id',
      ),
      array(
        'key'       => 'meta_data_$_value',
        'compare'   => '=',
        'value'     => $id,
      )
    )
  );

  $q = new WP_Query($arr);

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }

  wp_reset_postdata();

  return $result;
}

function is_exist_product($id) {
  $result = 0;

  $arr = array(
    'posts_per_page' => -1,
    'post_type' => 'product',
    'meta_query'    => array(
      'relation'      => 'AND',
      array(
        'key'       => 'meta_data_$_key',
        'compare'   => '=',
        'value'     => 'id',
      ),
      array(
        'key'       => 'meta_data_$_value',
        'compare'   => '=',
        'value'     => $id,
      )
    )
  );

  $q = new WP_Query($arr);

  if ($q->have_posts()) {
    // $result = $q->posts[0]->ID;
    $q->the_post();
    $result = get_the_ID();
  }

  wp_reset_postdata();

  return $result;
}

function update_product_manually($data, $product_id) {
  $product = wc_get_product($product_id);
  if ($product) {
    global $ss_ids;
    $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
    $set_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
    $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);
    $product->set_stock_quantity($data[$set_quantity]);
    $product->set_regular_price($data[$set_regular_price]);
    $product->save();
    // Uncomment this below to force delete woo cache:
    // wc_delete_product_transients($product_id)
  }
}

function is_exist_media($id) {
  $result = 0;
  $arr = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => - 1,
    'meta_query'      => array(
      'relation'    => 'AND',
      array(
        'key'     => 'ss_image_id',
        'value'   => $id,
        'compare' => '='
      )
    ),
  );

  $q = new WP_Query( $arr );

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }
  wp_reset_postdata();

  return $result;
}

function set_values($fields, $product_id, $item) {
  if (!$fields || !$product_id || !$item) {
    return;
  }

  $imageId = 0;

  $all_categories = get_categories(array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'name',
    'show_count'   => 0,
    'pad_counts'   => 0,
    'hierarchical' => 1,
    'title_li'     => '',
    'hide_empty'   => 0
  ));

  $product = wc_get_product($product_id);
  $filtered_data = array();
  $handlesToKeep = array();

  foreach ($fields as $field) {
    
    if ($field['help_text'] === 'set_name') {
      $product->set_name($item['title']);
    } else if ($field['help_text'] === 'set_regular_price') {
      $product->set_regular_price($item[$field['slug']]);
    } else if ($field['help_text'] === 'main_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
    } else if ($field['help_text'] === 'child_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
    } else if ($field['help_text'] === 'sub_child_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
    } else if ($field['help_text'] === 'set_gallery_image_ids') {
      $imagesArr = $item[$field['slug']];

      if (count($imagesArr) > 0) {
        foreach ($imagesArr as $key => $image) {
          $file_urls_arr = getFileURL($image['handle'], $image['metadata']['filename']);
          if ($key != 0) {
            unset($imagesArr[$key]);
            $handlesToKeep[] = $file_urls_arr;
          } else {
            $imageId = $file_urls_arr;
            set_post_thumbnail($product_id, $imageId);
          }
        }
      } 
    }
    wp_set_post_terms($product_id, $filtered_data, 'product_cat');
  }

  add_img_to_gallery($product_id, $handlesToKeep); 

  $product->save();
}

function get_column_field_id($helper_text, $fetch_variation_columns) {
  $result = null;
  foreach ($fetch_variation_columns as $column) {
    if (isset($column['help_text']) && $column['help_text'] === $helper_text) {
      $result = $column['slug'];
      break;
    }
  }
  
  return $result;
}

function is_variable_product($id, $product_id_slug, $product_variation_slug) {
  global $product_variations;
  $result = false;

  foreach ($product_variations['items'] as $product_variation) {
    if (
      $product_variation[$product_id_slug][0] === $id && 
      strtolower($product_variation[$product_variation_slug]) === strtolower('Yes')
    ) {
      $result = true;
      break;
    }
  }

  return $result;
}

function create_variation($pid, $term_slug, $filter_slug, $product_variations_fields) {
  global $product_variations, $ss_ids;
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
	$product_variation_sku = get_column_field_id('product_variation_sku', $product_variations_fields);
	$get_filter_id = get_column_field_id('get_filter_id', $product_variations_fields);
	$product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $attr_color = get_column_field_id('attr_color', $product_variations_fields);
  $variation_product_id = get_column_field_id('variation_product_id', $product_variations_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);

  foreach ($product_variations['items'] as $product_variation) {
    if (isset($product_variation[$filter_slug][0]) && $product_variation[$product_id_slug][0] === $term_slug) {
      $attribute_value = isset($product_variation[$filter_slug][0]) ? $product_variation[$filter_slug][0] : null;
      $quantity = isset($product_variation[$product_variations_quantity]) ? $product_variation[$product_variations_quantity] : 0;
      $sku = isset($product_variation[$product_variation_sku]) ? $product_variation[$product_variation_sku] : 0;
      // Set terms for the product
      wp_set_object_terms($pid, array($attribute_value), $product_variation[$get_filter_id], true);

      $is_set_color = isset($product_variation[$attr_color]);

      // Define the attribute data
      $attributes_data  = array(
        $product_variation[$get_filter_id] => array(
          'name' => $product_variation[$get_filter_id],
          'is_visible' => '1',
          'is_taxonomy' => '1',
          'is_variation' => '1'
        )
      );

      if ($is_set_color) {
        // if is set Attr Color, add Attributes but not create variations
        wp_set_object_terms($pid, array($product_variation[$attr_color]), 'pa_'.$ss_ids['filter_-_color_id'], true);

        $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
          'name' => 'pa_'.$ss_ids['filter_-_color_id'],
          'is_visible' => '1',
          'is_taxonomy' => '1'
        );
      }
      
      update_post_meta($pid, '_product_attributes', $attributes_data);

      // Create variation
      $variation = new WC_Product_Variation();
      $variation->set_parent_id($pid);
      $variation->set_attributes(array($product_variation[$get_filter_id] => $attribute_value));
      $variation->set_manage_stock(true);
      $variation->set_stock_quantity($quantity);
      $variation->set_sku($sku);
      $variation->set_regular_price($product_variation[$set_regular_price]);
      $variation->save();

      $variation_id = $variation->get_id();

      update_post_meta($variation_id, '_my_product_variation_id', $product_variation[$variation_product_id]);
    }
  }
}

function getFileURL($fileId, $fileName) {
  $url = 'https://app.smartsuite.com/api/v1/shared-files/' . $fileId . '/get_url/';
  $headers = array(
      'Authorization: Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
      'ACCOUNT-ID: sd0y91s2',
      'Content-Type: image/png'
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch);
  
  if (curl_errno($ch)) {
      echo 'Грешка: ' . curl_error($ch);
  }

  $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

  curl_close($ch);

  $tmp = download_url( $finalUrl );

  $file_array = array(
    'name' => $fileName,
    'tmp_name' => $tmp
  );

  $imageId = 0;
  $is_exist_media = is_exist_media($fileId);
  if ($is_exist_media !== 0) {
    $imageId = $is_exist_media;
  } else {
    $imageId = media_handle_sideload($file_array, 0);
  }
  update_post_meta($imageId, 'ss_image_id', $fileId);

  return $imageId;
}

function add_img_to_gallery($product_id,$image_id_array){
  update_post_meta($product_id, '_product_image_gallery', implode(',',$image_id_array));
}

function create_simple_product($pid, $term_slug, $product_fields) {
  global $product_variations, $ss_ids;
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_fields);
  $attr_color = get_column_field_id('attr_color', $product_fields);
	$product_id_slug = get_column_field_id('product_variation', $product_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_fields);
  $product_variation_sku = get_column_field_id('product_variation_sku', $product_fields);
  
  foreach ($product_variations['items'] as $product_variation) {
    $is_set_color = isset($product_variation[$attr_color]);
    if ($is_set_color && $product_variation[$product_id_slug][0] === $term_slug) {
      $quantity = isset($product_variation[$product_variations_quantity]) ? $product_variation[$product_variations_quantity] : 0;
      $is_stock = $quantity > 0 ? 'instock' : 'outofstock'; 
  
      // Define the attribute data
      $attributes_data = array();

      if ($is_set_color) {
        // if is set Attr Color, add Attributes but not create variations
        wp_set_object_terms($pid, array($product_variation[$attr_color]), 'pa_'.$ss_ids['filter_-_color_id'], true);

        $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
          'name' => 'pa_'.$ss_ids['filter_-_color_id'],
          'is_visible' => '1',
          'is_taxonomy' => '1'
        );
      }

      update_post_meta($pid, '_product_attributes', $attributes_data);
      update_post_meta($pid, '_manage_stock', true);
      update_post_meta($pid, '_stock_status', $is_stock);
      update_post_meta($pid, '_stock', $quantity);
      update_post_meta($pid, '_price', $product_variation[$set_regular_price]);
      update_post_meta($pid, '_sku', $product_variation[$product_variation_sku]);
    }
  }
}

function create_woocommerce_products($filteredData) {
  global $ss_ids;

  $product_fields = fetch_column_fields($ss_ids['products_app_id']);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  
  $product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $product_variation_slug = get_column_field_id('is_variation', $product_variations_fields);
  $filter_helmet_size_slug = get_column_field_id('filter_helmet_size', $product_variations_fields);
	$filter_clothing_size_slug = get_column_field_id('filter_clothing_size', $product_variations_fields);
	$filter_boot_size_slug = get_column_field_id('filter_boot_size', $product_variations_fields);
	$prduct_sku = get_column_field_id('set_sku', $product_fields);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);

  foreach ($filteredData as $item) {
    $incoming_id = $item['id'];
    $product_id = is_exist_product($incoming_id);

    if (!$product_id) {
      // if Product no exists
      if (is_variable_product($incoming_id, $product_id_slug, $product_variation_slug)) {
        $variations = new WC_Product_Variable();

        $variations->set_name($item['title']);
        $variations->set_sku($item[$prduct_sku]);
        
        $variations->save();
        $pid = $variations->get_id();

        if (!is_wp_error($pid)) {
          $product_id = $pid;
        }
        
        set_values($product_fields, $pid, $item);
        update_acf($item, $pid, false);
        
        if ($filter_clothing_size_slug) {
          create_variation($pid, $incoming_id, $filter_clothing_size_slug, $product_variations_fields);
        }

        if ($filter_helmet_size_slug) {
          create_variation($pid, $incoming_id, $filter_helmet_size_slug, $product_variations_fields);
        }
        
        if ($filter_boot_size_slug) {
          create_variation($pid, $incoming_id, $filter_boot_size_slug, $product_variations_fields);
        }

      } else {
        $simple_product = new WC_Product_Simple();
        $simple_product->set_name($item['title']); // product title
        $simple_product->set_status('publish'); // product title
        $p_id = $simple_product->save();

        if (!is_wp_error($p_id)) {
          $product_id = $p_id;
        }

        $item['product_variation_id'] = $item[$product_var_id];
        set_values($product_fields, $p_id, $item);
        update_acf($item, $p_id, false);
        create_simple_product($p_id, $incoming_id, $product_variations_fields);
      }
    }

    if (!$product_id) {
      return;
    }
  }
}

function update_woocommerce_product($data, $update_product) {
  global $ss_ids;
  $product_fields = fetch_column_fields($ss_ids['products_app_id']);    
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);
  $set_gallery_image_ids = get_column_field_id('set_gallery_image_ids', $product_fields);
  $is_variation = get_column_field_id('is_variation', $product_variations_fields);

  foreach ($data as $item) {
    $incoming_id = $item['id'];
    if ($incoming_id === $update_product) {
      $product_id = is_exist_product($incoming_id);
      $product_no_variation_id = is_product_id('["'.$incoming_id.'"]');
      $product_variation_id = is_variation_id($incoming_id);
      $product = wc_get_product($product_id);
      // pretty_dump($product_id);
      // pretty_dump($product_no_variation_id);
      // pretty_dump($product_variation_id);
      if ($product_id !== 0) {
        pretty_dump('tuk sme');
        if (strtolower($item[$is_variation]) === strtolower('No') || !$product->is_type( 'variable' )) {
          $item['product_variation_id'] = $item[$product_var_id];
        }
        set_values($product_fields, $product_id, $item);
        update_acf($item, $product_id, false);
        if (count($item[$set_gallery_image_ids]) === 0) {
          delete_post_thumbnail($product_id);
        }
      } else if ($product_variation_id !== 0) {
        update_product_manually($item, $product_variation_id);
      } else if ($product_no_variation_id !== 0) {
        update_product_manually($item, $product_no_variation_id);
      } 
    }
  }
}