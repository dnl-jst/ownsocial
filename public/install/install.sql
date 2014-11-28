-- Create syntax for TABLE 'configs'
CREATE TABLE `configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `configs` (
  `id`, `key`, `value`
) VALUES (
  NULL, 'default_portrait_id', 1
);

-- Create syntax for TABLE 'files'
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `group_id` bigint(20) unsigned DEFAULT NULL,
  `content` longblob NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `created` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `files_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `files` (`id`, `user_id`, `group_id`, `content`, `type`, `created`)
VALUES
	(1, NULL, NULL, X'89504E470D0A1A0A0000000D49484452000001900000019008020000000FDDA19B0000001974455874536F6674776172650041646F626520496D616765526561647971C9653C0000032869545874584D4C3A636F6D2E61646F62652E786D7000000000003C3F787061636B657420626567696E3D22EFBBBF222069643D2257354D304D7043656869487A7265537A4E54637A6B633964223F3E203C783A786D706D65746120786D6C6E733A783D2261646F62653A6E733A6D6574612F2220783A786D70746B3D2241646F626520584D5020436F726520352E352D633032312037392E3135353737322C20323031342F30312F31332D31393A34343A30302020202020202020223E203C7264663A52444620786D6C6E733A7264663D22687474703A2F2F7777772E77332E6F72672F313939392F30322F32322D7264662D73796E7461782D6E7323223E203C7264663A4465736372697074696F6E207264663A61626F75743D222220786D6C6E733A786D703D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F2220786D6C6E733A786D704D4D3D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F6D6D2F2220786D6C6E733A73745265663D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F73547970652F5265736F75726365526566232220786D703A43726561746F72546F6F6C3D2241646F62652050686F746F73686F70204343203230313420284D6163696E746F7368292220786D704D4D3A496E7374616E636549443D22786D702E6969643A32314643354546333435413731314534424339444235423045463835453737452220786D704D4D3A446F63756D656E7449443D22786D702E6469643A3231464335454634343541373131453442433944423542304546383545373745223E203C786D704D4D3A4465726976656446726F6D2073745265663A696E7374616E636549443D22786D702E6969643A3231464335454631343541373131453442433944423542304546383545373745222073745265663A646F63756D656E7449443D22786D702E6469643A3231464335454632343541373131453442433944423542304546383545373745222F3E203C2F7264663A4465736372697074696F6E3E203C2F7264663A5244463E203C2F783A786D706D6574613E203C3F787061636B657420656E643D2272223F3ED5284BC000001E0C4944415478DAECDD69571449DAC6F1665F641359151010174001011190B5D83DF372BEC47C8DFE4CD340153BC826AB8820A2A020BBEC25B2D713D3CE9967A6DB5640E2AECCAAFFEF85A7CF8C7267460657456445467AFFFAEBAFBF00801978D20400082C0020B00010580040600100810580C00200020B00082C0004160010580040600120B00080C00200020B00810500041600105800082C0020B00080C00240600100810500041600020B00082C0020B00010580040600120B00080C00200020B00810500041600105800082C0020B00080C00240600100810500041600020B00082C0020B00010580040600100810580C00200020B00082C0004160010580040600120B00080C00200020B00810500041600020B00082C0020B00010580040600100810580C00200020B00082C0004160010580040600120B00080C00200020B00810500041600105800082C0020B00080C0026076DE34C1C5DBCEDBFB1FFFF8475858984CB99191917FFEF39F34FBCFFBFBDFFF9E9A9A2A53ABBDBDBDABAB8B366784E57CC7C7C74D4D4D62E5323333A3A2A268F69F9498982896566B6B6BDDDDDDB439816514AF5FBF7EF7EE9DD0A5F2F4ACAAAAA2CD7F868787477575B54C2D87C3515F5F7F7A7A4AB313580662B55A4F4E4E646A252727A7A4A4D0E617969B9B1B1D1D2D536B7474746E6E8E3627B08C657D7DFDF9F3E762E52A2B2BD5308166BF007F7FFF929212995A76BBBDB9B9993627B08CA8A3A363777757A6566464644E4E0E6D7E01E5E5E581818132B5545AEDEFEFD3E60496111D1D1D497E9CAA6182AFAF2FCD7EDEA0CFCECE96A9353333F3F2E54BDA9CC032AEF1F1F10F1F3EC8D4BA72E58AD8D4C665D4D4D4787A4AF476F5E9D5D0D04083135846D7D8D828F695506E6EAED8FA2F1770EFDEBDA4A424995A3D3D3D1B1B1BB439816574ABABABC3C3C332B57C7C7C2A2A2A68F3B3F0F2F2AAACAC94A9B5B6B6F6ECD933DA9CC03287D6D656BBDD2E532B2D2D2D2E2E8E36FFA1C2C2C2AB57AF0A1472381C6A32C8C22B02CB340E0E0EDADBDBC5CAB18EF4878283835560C9D47AF1E285D87D4C020B97636464E4E3C78F32B5D408EBFEFDFBB4F977A8C9A0CC37AA9F3F7F967C4E8BC0C2A5B15AAD6A762053ABBCBCDCCBCB8B36FFA6F8F878B1406F696961E11581654A8B8B8BA3A3A332B5C2C2C20A0A0A68F33FF3F0F0A8A9A991A9F5FEFD7B351FA4CD092CB3529FB75FBE7C91A955585828B680DB441E3E7C181B1B2B50E8F8F8F8B7DF7EA3C1092C135369D5D1D12153CBCFCFCF62B1D0E6FFCDD7D7B7B4B454A6160BAF082C57303838B8BCBC2C532B33333332329236FF8FB2B2B2A0A02081429F3E7D627F3E02CB15381C8EC6C646A1ABC85659FFE5DAB56BB9B9B932B5D8F18AC0721DF3F3F3620FC1DEBA758BADB2BEAAAEAE96F9E69485570496AB696A6A3A383890A9555151C15659B76FDF9609EEBDBD3D9BCD460F27B05CCAE7CF9FC5EE71444545B9F95659925363165E1158AEA9AFAF6F6D6D4DA6564949898F8F8FDB36757E7EFEB56BD7040AA999A0D8523B1058A21C0E87D56A95A9E5CE5B65A9732F2A2A1228C4C22B02CBC5CDCECE4E4E4ECAD47AF4E8516868A81B36724545859F9F9F40A1DEDEDEF5F5757A3581E5CA6C36DBE1E1A14021352514DBFEC938AE5FBF9E91912150484555676727FD99C072713B3B3B3D3D3D32B5D2D2D26EDCB8E156CD5B535323F30D290BAF082C77D1DDDD2DF60C87D8EB428D408DAD64F6327CF9F2E5FBF7EFE9C904965B509FCC622B77D42F707A7ABA3BB4AA9A02CB3C4AC9C22B02CBED4CFF4EA696FA3596794F8C739594940407070B146A6D6D5599451F26B0DC4B6363E3F1F1B140A1B0B030B1DD819D459D635E5E9E40A1B9B9B99191117A2F81E576B6B6B6FAFAFA646AB9FC5659353535DEDEDEBAABB0F08AC0726B5D5D5DDBDBDB0285FCFCFCCACBCB5DB519939393EFDCB92350487DC07CFAF4897E4B60B929F5892DF6C282ACAC2C97DC2ACBC3C343E69BD08D8D0D165E1158EE6E727272767656E202BBE856597979793241DCD0D0707272428F25B0DC5D6363A3CC6FC2ADDFB952D30504041417170B141A1F1F9F9999A1AF1258F8D7EEBA03030332B52A2B2B5D69AB2C8BC5A2324B77952F5FBE883DB50E02CB04DADBDB777777050AB9D25659D1D1D1595959028558784560E17F1C1D1DA9DF0A995A6A0EE51A5B65D5D4D4082C889D9F9F1F1E1EA68B1258F81F63636373737302858282825C60ABACF4F4F49B376FEAAE727272C2C22B020BDFD6D8D828B301C0A3478F424242CCDB50DEDEDE1515150285243789058165322B2B2B32B30FB36F9555545424B037E1E6E6260BAF082C7C4F5B5BDBE7CF9F65A65426DD2A4B8D0DF3F3F3050A353434C83CEC0902CBACF6F7F75566C9D432E93A5275D8025F1ABC7AF5EADDBB777448020B3F303A3ABAB8B82850283E3EDE745B65DDBC79332D2D4D7715165E1158382B87C3A12623EA4F815AE6DA2A4BECB141B18939082C57A046582F5EBC1028141616565050609666C9C9C9898989D15D657E7E7E6868884E4860E11C9A9B9BD5C444A09059B6CAF2F3F32B2D2DD55D85855704162E42A595CC77EAFEFEFEA6D82A4B1DA440B03E7FFE9C855704162E62606060656545A050565656444484919B22323252E011C8CDCDCDF6F6763A1E81858B70381C8D8D8D12D7DEF05B655557570B7C3920B6CB3E082CD7343737373E3E2E50282525253939D9988D70EFDE3D81639B989878FBF62D5D8EC0C24F696A6A3A38381028A4065906DC2A4B0DAC041E1BDCDFDF9719CC82C0727176BBFDD9B3670285A2A2A2B2B3B38D76FA4F9E3C090F0FD75D85855704162E8DD8CB5A4A4A4A0CB555567070B0C032B18F1F3FB2F08AC0C2A5393D3D9599B0040505C96C917E466A32E8E7E7A7BB6DEBEBEB659E2B0081E52E6667675FBF7E2D50282F2FCF205B65C5C5C5DDBF7F5F7795E7CF9FCBAC1D0181E55EAC56EBD1D191EE2AC6D92AABBABA5AF797005B5B5B627B6380C0722F3B3B3B3D3D3D02858CB055566666A6C031B0F08AC08246CF9E3DDBDCDC9419DD38F134D5284FE069A1C9C9C9E9E9693A1581055D4E4F4F6D369B40A1B8B838276E95555C5C1C1C1CACB5040BAF082C4878F3E68DCCB8C062B1787979C99F604848485E5E9EEE2A1D1D1D76BB9DEE4460413BABD52A70E7C5595B6509EC80BCB8B828F6AA6D1058EE6E7373B3BFBF5FA090FC5659F1F1F1BA774056D3EADF7EFB8D85570416E47476766E6F6FEBAEE2E7E7A72686622725B303B21A5B2D2F2FD385082CC85153C2E6E6668142999999515151322795959575FDFA75AD2554CAB3F08AC082134C4C4CCCCECE6AEF16525B65F9F8F808EC80DCD8D828B0F8160416BEC16AB59E9C9CE8AE929C9C7CFBF66DDD55049632BC7EFDFACD9B37741B020BCEB1B6B63638382850A8A2A242EB5332024B190E0E0E58784560C1C9DADBDB7777777557D1BDA5BAC562D1BD94A1A3A343A0A14060E17B0E0F0F5B5B5B050AA9299BA64C898989D1BD2BC3D2D2D2F3E7CFE92D04169C6F6C6C6C7E7E5E77157D5B655556566A9D6FB2F08AC082B1343636AA5F4BDD55F2F2F22EFDBE784A4A4A525292D6C31E1C1C54232C3A098105A3585E5E1E1919D15DE5D2375150032BDD2F98D8DEDE96993283C0C239A85FCBBDBD3DDD55323232A2A3A32FEBA73D7CF850F7AA54995D0F4160E17CF6F7F705DE5AACC64497B58ED4DBDBBBA4A444EBD1BE79F3666A6A8ABE4160C1888687871717177557494A4A4A4949F9F99FF3E4C913AD2B450F0E0E1A1A1AE81504160CEAEBABED05BE0EFBF975A48181818F1F3FD67A909D9D9D3B3B3BF40A020BC6B5B0B0303636A6BB4A5454D4C3870F7FE6279496966A7D7FD7D2D292CC0E3C20B0F0539A9B9BBF7CF9A2BB4A7171B1B7B7F7C5FE6D686868565696BE6363E1158105D3D8DBDBEBEAEAD25D252424243F3FFF62FFB6A4A4E4C26177164343432CBC22B0601A322F0755817581695D787878464686BEA3DAD9D9696969A10F1058300D351BB25AADBAAB0404045C605D427979B9A7A7C6CE66B3D958784560C1643E7CF8F0EAD52BDD55727272CEB534213A3A3A353555DFF14C4F4F4F4E4E72F5092C984F5353D3C1C181D6123E3E3E656565E71A5EE97BCEF9F0F0B0BEBE9EEB4E60C194767777BBBBBB7557C9C8C888888838CBDF8C8F8FD7BA73290BAF082C985B6F6FEFFAFABADE7EE3E979C637EB68DDB27D7979B9AFAF8F2B4E60C1C44E4F4F05F605BE7BF76E5C5CDCF7FF4E6262A2BE6D6458784560C145CCCCCC083C00FCC34196D6E195CC439420B02041608B959B376FAA31D47786570909099A4AEFEEEEB2F08AC082EBD8DEDE16B8BFF39D41D693274FF4D5B5D96C8787875C65020BAEA3ABAB6B7373536B891B376E7CF34BC0F8F8F8E4E4644D45A7A7A7272626B8BE04165CCAC9C949535393EE2ADFBC51A5E9D515BFFCBEF08A1DAF082CB8A6A9A9A9B76FDF6A2D111B1BFB8785ECEA7FB975EB96BE61A39AED7265092CB826ABD57A7C7CACB5C41FC653FABE1C5C5959E9EDEDE59A125870591B1B1BBAB7B58B8E8E7EF0E0C17FFE5BD3D27687C3C1C22B020BAE4F4DA3743FBF525454F4F581417D77AF464646161616B89A04165CDCD1D1517373B3D612111111191919919191F7EEDDD3F1F3777777759F028CCF9B267013AF5EBDCACECEFECE3ACF9FF7B7BFFDEDF4F454D3C60C02BB508011160C44F7ABED3D3D3D356D82FCF6ED5B817DBE4060C140D6D6D6060707CD389F65E115082C77D4D6D666B7DBCD75CC5D5D5D5B5B5B5C3B10586EE7F0F0506596890E787575B5A7A7870B0702CB4D8D8E8ECECFCF9BE2501D0E477D7D3D0BAF4060B935ABD5AAF5EEBB1B662B082CE8B2B4B4A4B2C0E00769B7DB059EDC06810513686969D9DBDB33F211B2F00A0416FE6D7F7FBFA3A3C3B087F7EEDDBBF1F1712E13082CFCDBD0D0909A1B1AF0C0587805020B7FE470381A1B1B0DF81D5C7777B7EE8D524160C17C3E7EFCF8F2E54B431DD2DADA9AC08B604160C1949A9A9AF6F7F78D33E8ABAFAF37C5920B10587082BDBDBDAEAE2E831CCCE8E8E8DCDC1C17050416FE527F7FFFEAEAAAD30FC36EB7B3E315082CFC782266B55A9D7E182AAD8C3339058105E37AFFFEBD73DFF437333363B4DBFF20B0605C369BCD592BCB8F8E8EEAEBEBB90420B07056BBBBBBCEDAC845D565E115082C9C3B38D6D7D7E5EBBE79F386C6078185F3393D3D551343F9BAB5B5B5343E082C9C9B536E63C5C7C7676565D1F820B0700E1E1E1ECE1AEC949797FBFBFB73094060E1AC1E3D7A141313E394D2414141168B854B00020B67121818585252E2C40378F8F0616C6C2C170204167EACBABA3A2020C0997DD1D3F3E9D3A79A5E1C0D020BAE232121E1C183074E3F8CEBD7AF67676773394060E12F39F15EFB9F9597973B77A007020B86F6F8F1E3E8E868831C8C4AABCACA4A2E0A082C7C4350509073EFB5FF596666667C7C3C97060416FEA8BABADACFCFCF805354EEBE83C0C2FF484C4C4C4F4F37E081C5C4C4A8892A17080416FE7F2053535363D8C32B2E2EBE72E50A97090416FEA5B0B0302A2ACAB087E7EFEFAFA6AB5C261058F8253838F8C99327063FC8FBF7EFAB492B170B0496BB33E0BDF66FAAADADF5F4A49782C07263494949696969A638D4C8C8C88282022E19082C77BDE49E9EE6DA304F4D5D434242B87020B0DC51616161444484890E584D5D8DFC6D26082CE8A2862AC6BFD7FE67F7EEDDBB75EB16970F04967B5143155F5F5F331E3977DF4160B9173548514315931E7C7878785151111791C0827B5C699DF7DA878787373636749F426161615858189792C082EB53C3133548D1F193B7B7B71B1A1A9A9B9B759F828F8F0F2F0423B0E0FA424343D5F044D30FEFEDED3D3D3D9D9A9A9A9B9BD37D22B76FDFBE7BF72E1794C0822BABA9A951C3134DC3ABA1A1A1AFFF2D30C8FAE5F735FADEDEDE5C53020BAEE9CE9D3BFA46255F87575FFF7B616161626242F7E9848585196DC7411058B81C5E5E5EFAF63CF8EFE1D5572D2D2D272727BA4FEAF1E3C79AEEC781C082331517175FBD7A556078F5D5D6D6D61F224C073525ACABABE3E2125870292AAAF2F3F3C586575F7574747CF9F245F7A92527279BE5F96D10583893DADA5A4DF7DA958181813F0CAFBEDADFDF57232F81B3ABAAAAD2777620B020EAEEDDBB2929299A7EB8DD6E5781F59DA9A29A1BEA3EC1909090F2F2722E348105D3F3F6F6D6BABF705F5FDFF1F1F15FFDBF6AE4D5DEDE2E709AB9B9B99191915C6E020BE6565C5CACEF2996EDEDEDE7CF9F7FFFEFBC7CF972616141F7697A79793D7DFA94CB4D60C1C4C2C3C3F5DD6B57BABBBBCFB276C16AB53A1C0EDD279B9090909999C94527B06056B5B5B5FAD6826F6C6C0C0F0F9FE56FAA11D6F8F8B8C0F95A2C1653EC4F0F020B7F949A9AAA75AFBBCECECEB38F9B5A5A5A0E0F0F759F72505090CA2C2E3D8105935103ABAAAA2A7D3F7F6565E5E5CB9767FFFBBBBBBB324B1CB2B3B3636363E9000416CCA4B4B434343454DFCF6F6B6B3BEF3FE9EEEE1658E260BA376B80C072771111118F1F3FD6F7F3E7E7E7A7A7A7CFFBAF4E4E4ED4C450E0F4E3E2E2727272E8060416CC410D31BCBCBC0C35BCFA6A6262E2C3870F022D505656E6EFEF4F4F20B06074696969494949FA7EFECCCCCCCF848ECD66FBE6733C972B303050EB2D3C1058B8043E3E3EBA7F515B5B5B7FE69F2F2F2FBF78F142A0293233336FDCB8419720B0605CE5E5E55ADF8D3C3939B9B4B4F4F391B7BFBFAFBB293C3C3C9E3E7DAAFEA457105830A2C8C8C8DCDC5C7D3FFFB2EE9AEFEDED7575750934484C4CCCA3478FE81804168C48F7BDF6E1E1E1CDCDCD4BF951FDFDFDABABAB026D52525272E5CA15FA0681056379F0E0416262A2BE9FAF267197B8EF82C3E1B05AAD02CD121010C0DD77020BC6E2EBEB5B5151A1B5444F4FCFE5DE787AFFFEFDAB57AF64A2FCE6CD9B7412020B46515E5E1E1C1CACEFE76F6D6DE978B0C666B31D1C1CC84C96B9FB4E60C110A2A2A2B4DE6B57D46450C7E229BBDDDEDDDD2DD3440505057415020BCE575757E7E9A9F1F22D2E2E9EEB39E7735103B74F9F3E09B452515191D64128082CFC58565656424282D6124D4D4DFA7EB81AB83536360A34949F9F9FD6ADA24160E1C7BF84BA5FBE303535353737A7B5C4ECECECEBD7AF059A2B2D2D2D3939996E4360C1392C164B505090BE9F7F7272D2DCDC2C702256AB55607BBF5F7EBFFBAE75FA0C020BDF161313939D9DADB5C4C8C8C8C6C686C0B9ECECECC8DC7DBF76ED5A5151119D87C08234DDF7DA2F77A5E80FF5F4F4C884636161A1D6AD0D4160E18F1E3E7C181717A7B5841AF208BC68FE3F4E4F4F65D6BEFBF8F8B02529810539FEFEFEBAEFB5AFAFAFF7F5F5099FD7DBB76F65EEBEDFF91D1D89C082048BC5A2FB815E996DF6FEACB1B15166ED7B7575B5BE17A081C0C2BF5DBF7E5DCD07B596989E9E56831DA79CDDEEEEEEB367CF040A5DBD7AB5B8B898EE446041230F0F0FDDF7DA4F4E4ED4F0CA89E7D8DBDB2BB3F34C7E7E7E7878389D8AC0822ED9D9D96A84A5B5C4C0C080CCB7757FC5E1703434340814525342EEBE1358D0C5DFDFBFACAC4C6B09BBDDDED1D1E1F4339D9B9B1B1B1B132874EBD6ADD4D454BA168185CB575959191818A8B5447B7BBBCC8AF31F6A6A6A925954515D5DEDE3E343EF22B070996EDCB8919595A5B5C4E2E2E2C8C88841CE776F6F4F66D96A4848486969291D8CC0C2A5F97AAF5DEB1674627B169FDDD0D090CA5081427979799191917433020B97232727273636566B89F1F1F18F1F3F1AEAAC5586D6D7D70B2C07F3F2F2E2EE3B8185CB111818A8FB5EFBC1C1C1A5BCBFEBD22D2D2DC9CC52131313333232E86C04167E56555555404080D612BDBDBDBBBBBBC63C7D95A476BB5DA090C562F1F5F5A5BF1158B8B8F8F8F8070F1E682DB1B1B121B3B5CB85477FADADAD02858283835566D1E5082C5C90878787C0EB5ED410C6298F0D9EDD8B172F74EF7AFA554E4E4E4C4C0C1D8FC0C245E4E5E5E9FEFDF9F0E183CC06093FC96AB53A1C0EEDBF039E9E757575743C020BE776E5CA95929212DD558C79AFFDCF969797D5384BA0505C5C9CEE67CB4160B9A0AAAA2A7F7F7FAD25262727171616CCD2202A5B65769EB1582CBA5B1E04964B494848D07DAFFDE4E4C42CC3ABAFF6F6F664769E090C0CACACACA41312583893AFF7DA7557191919D9DCDC3457CBF4F5F5C9EC24919595A57B570C10582E223F3F3F3A3A5A6B0935B732C2AE0CE7757A7A2AF3DA31F599F1F4E953DDDFCF82C032BDA0A020819D30D55045CDB0CCD83E5353533333330285626363737373E9900416BEA7BABADACFCF4F6B899D9D9D9E9E1EF33691D87EF3A5A5A5BAF7F301816562898989E9E9E9BAAB7475751D1F1F9BB795D6D6D6868787050A050404545555D12D092C7CEB02787A0ADC6B5F5D5D35CEA65717D6D6D62633A5CDC8C8484848A0731258F8A3828202815D99D4AFBAC09271DDF6F7F7D53851A696C0D35120B04C263838F8C99327BAABBC7FFFFECD9B37AED1620303036A6E2850283A3A3A3F3F9F2E4A60E1FF09DC6BFFC53C0FE29C851A278ABD8EACB8B8382828885E4A60E15F929393D3D2D2745799989890D97158CCCCCC8CCC80517D96D4D4D4D051092C08DD6B37DD833867D4D4D4A44E4DA090FA44494A4AA2BB1258EEAEB0B0F0DAB56BBAAB0C0D0D6D6D6DB95EEB6D6C6C0C0C0CC8D4529F2B5ADFB90D02CBE842424204EEB5EFEFEF777676BA6A1B7674747CFEFC59A050444484FA74A1D31258EE4B7D680BEC23DEDBDB2BF35252A7383C3C947983A1A23E5D424343E9B704963B4A4949B97BF7AEEE2A3B3B3B7D7D7DAEDD92232323CBCBCB0285D4A70B77DF092CB76C6E4F4F99AEAF2683A67E10E72C24DF02AB3E636EDFBE4D0726B0DC4B5151517878B8EE2AABABABA3A3A3EED09E73737393939332B5D4278D9797177D98C0721761616132B76F5B5A5A5CE0419C33B2D96C4747470285AE5EBD2AB00510082CA3A8ADADF5F1F1D15D657676F6EDDBB7EED3AA3B3B3BFDFDFD32B50A0A0A546CD193092CD777E7CE1D819B206A60E5922B45BFAFABAB4BC59640216F6F6F81E5BE20B09CCCCBCBABBABA5AA0D0C4C4C4D2D292BB35EFF1F1715B5B9B4CAD949494D4D454BA3481E5CA8A8B8B05A612EAF756E6F5EE06343636F6F1E347995A5555556AA845AF26B05C938AAA8282028142C3C3C32EF920CE19D96C3699AF1A424343CBCACAE8D804966BAAADAD15F840FEF2E58B19DF887389161616C6C7C7656AE5E5E5454444D0B7092C5773F7EEDD9494148142BDBDBDFBFBFB6EDEDACDCDCD32AF89F6F2F2AAABABA37B13582E450DAC64EEB56F6F6FBBFC83386761B7DB5570CBD44A4C4CBC7FFF3E6D4E60B98E929292B0B03081426A3228B33F94F1F5F4F488BDDABAB2B252E02176105812C2C3C31F3F7E2C50686565656C6C8C06FF4A72CFC2E0E0E0F2F272DA9CC0720532F7DA7F71B30771CE627272F2C3870F32B5727373A3A3A3697302CBDC5253536FDDBA2550687676F6DDBB7734F81F58AD5699D7447B7A7A72F79DC032371F1F1F997BED6A60D5DCDC4C837F739AFCE2C50B995AF1F1F1595959B439816556A5A5A521212102855EBD7A25B3839D19B5B6B68AADF3B0582CFEFEFEB43981653E11111179797902858E8E8EDCF6419CB3D8DBDB7BF6EC994CAD2B57AEA8CCA2CD092CF3A9ADAD95D9E66D7878787B7B9B06FF8EFEFEFEF5F575995AD9D9D9D7AF5FA7CD092C33494F4F97798D1D0FE29CC5E9E9695353934C2D0F0F8FBABA3AF527CD4E6099838F8F4F5555954CADDEDE5E996750CC6E7A7A5AEC5B5435C2CAC9C9A1CD092C73282F2F0F0E0E1628B4B5B525F6008A0BB0D96C628F01949595050404D0E60496D1454646E6E6E6CAD4529341994546AEE1D3A74FC3C3C332B5545AC9AC6821B0F053EAEAEA64EEB52F2D2DF120CE79B5B5B5EDEDEDC9D47AF0E0417C7C3C6D4E6019574646C6CD9B37656AB194E1020E0E0E3A3B3B656A71F79DC032345F5F5FB13538EFDEBD9B9999A1CD2F60707070757555A6567474B4CC73EF0416CE4DEC5EBB7BBE11E7125BCF66B389952B2E2E0E0A0AA2D9092C63898A8A12BBD73E3E3EBEB2B2429B5FD8ECECECD4D4944C2D7F7F7FEEBE135886F3F4E9534F4F8936E4419C4BD1D4D4747C7C2C532B3D3D3D3131913627B08C222B2B4BECFBA0C1C141997785BAB6CDCDCD818101B172757575329F6704167EC0CFCF4F6CB7C9BDBDBDAEAE2EDAFC52747474ECEEEECAD48A88889079C31B81851FB0582C6277557B7A7A7810E71227D7928F61161515C9EC354460E12FC5C6C6666767CBD4DADADAEAEFEFA7CD2FD1E8E8E8E2E2A24C2D5F5FDF9A9A1ADA9CC072A6DADA5AB17B13EDEDED3C8873B9849738DCBB774FE6DD94EEC0E3D75F7FA5150030C20200020B00810500041600105800082C0020B00080C00240600100810500041600020B00082C0020B00010580040600100810580C00200020B00082C0004160010580040600120B00080C00200020B00810500041600020B00082C0020B00010580040600100810580C00200020B00082C0004160010580040600120B00080C00200020B00810500041600105800082C0020B00080C00240600100810500041600020B00082C0020B00010580040600120B00080C00200020B00810500041600105800082C0020B00080C00240600100810500041600020B00082C0020B00010580040600100810580C0020051FF27C000329071E6BE8C21810000000049454E44AE426082', 'image/png', 1415900041);

-- Create syntax for TABLE 'groups'
CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `type` enum('public','protected','hidden') NOT NULL DEFAULT 'hidden',
  `portrait_file_id` bigint(20) unsigned DEFAULT NULL,
  `created` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `portrait_file_id` (`portrait_file_id`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`portrait_file_id`) REFERENCES `files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'likes'
CREATE TABLE `likes` (
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` bigint(20) NOT NULL,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'posts'
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `root_post_id` bigint(20) unsigned DEFAULT NULL,
  `parent_post_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned DEFAULT NULL,
  `visibility` enum('public','contacts','me','group','comment') NOT NULL DEFAULT 'public',
  `content` mediumtext NOT NULL,
  `image_file_id` bigint(20) unsigned DEFAULT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_post_id` (`parent_post_id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  KEY `root_post_id` (`root_post_id`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`parent_post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_5` FOREIGN KEY (`root_post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'relations'
CREATE TABLE `relations` (
  `user_id` bigint(20) unsigned NOT NULL,
  `user_id2` bigint(20) unsigned NOT NULL,
  `created` bigint(20) NOT NULL,
  `confirmed` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`user_id2`),
  KEY `user_id` (`user_id`,`confirmed`),
  KEY `user_id2` (`user_id2`,`confirmed`),
  CONSTRAINT `relations_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create syntax for TABLE 'user_groups'
CREATE TABLE `user_groups` (
  `user_id` bigint(20) unsigned NOT NULL,
  `group_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `confirmed` bigint(20) DEFAULT NULL,
  `role` enum('member','admin') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'member',
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `user_groups_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `user_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'users'
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('user','admin') NOT NULL DEFAULT 'user',
  `email` varchar(100) NOT NULL DEFAULT '',
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `email_confirmation_hash` varchar(32) DEFAULT NULL,
  `account_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `department` varchar(255) DEFAULT NULL,
  `portrait_file_id` bigint(20) unsigned DEFAULT NULL,
  `created` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `portrait_file_id` (`portrait_file_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`portrait_file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;