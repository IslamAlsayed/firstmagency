<section class="section your-domain-section relative py-20 bg-slate-50 overflow-hidden">
    {{-- <form action="https://client.firstmagency.com/cart.php" method="post" class="mx-auto px-4 relative z-10" id="domainForm"> --}}
    <form action="{{ route('cart') }}" method="post" class="mx-auto px-4 relative z-10" id="domainForm">
        @csrf

        <div class="text mb-12 font-semibold">
            <h2 class="font-black text-[#1a2b50] mb-2 tracking-tight">
                {{ __('main.domain_register_title') }} <span class="inline-block main-domain-badge">.com</span>
            </h2>
            <p class="text-2xl text-[#1a2b50] opacity-90">{{ __('main.domain_register_subtitle') }}</p>
        </div>

        <div class="filter-domains">
            <div class="flex justify-center mb-10 font-semibold">
                <label for="domain1" class="filter-domain-button active">
                    {{ __('main.domain_register_now') }}
                    <input type="radio" name="domain" id="domain1" checked value="register">
                </label>
                <label for="domain2" class="filter-domain-button">
                    {{ __('main.domain_transfer') }}
                    <input type="radio" name="domain" id="domain2" value="transfer">
                </label>
            </div>
        </div>

        <div class="mx-auto group">
            <div class="flex items-center justify-between gap-4 enter-domain">
                <div class="domain-extension cursor-pointer">
                    <select name="extension" id="domain-extension" class="w-full h-full">
                        <optgroup label="Official / رسمي">
                            <option value=".eg">.eg</option>
                            <option value=".sa">.sa</option>
                            <option value=".com.sa">.com.sa</option>
                            <option value=".net.sa">.net.sa</option>
                            <option value=".org.sa">.org.sa</option>
                            <option value=".edu.sa">.edu.sa</option>
                            <option value=".gov.sa">.gov.sa</option>
                            <option value=".ae">.ae</option>
                            <option value=".com.ae">.com.ae</option>
                            <option value=".net.ae">.net.ae</option>
                            <option value=".org.ae">.org.ae</option>
                            <option value=".kw">.kw</option>
                            <option value=".com.kw">.com.kw</option>
                            <option value=".net.kw">.net.kw</option>
                            <option value=".org.kw">.org.kw</option>
                            <option value=".qa">.qa</option>
                            <option value=".com.qa">.com.qa</option>
                            <option value=".net.qa">.net.qa</option>
                            <option value=".org.qa">.org.qa</option>
                            <option value=".bh">.bh</option>
                            <option value=".com.bh">.com.bh</option>
                            <option value=".net.bh">.net.bh</option>
                            <option value=".org.bh">.org.bh</option>
                            <option value=".om">.om</option>
                            <option value=".co.om">.co.om</option>
                            <option value=".com.om">.com.om</option>
                            <option value=".net.om">.net.om</option>
                            <option value=".org.om">.org.om</option>
                            <option value=".jo">.jo</option>
                            <option value=".com.jo">.com.jo</option>
                            <option value=".net.jo">.net.jo</option>
                            <option value=".org.jo">.org.jo</option>
                            <option value=".lb">.lb</option>
                            <option value=".com.lb">.com.lb</option>
                            <option value=".net.lb">.net.lb</option>
                            <option value=".org.lb">.org.lb</option>
                            <option value=".ps">.ps</option>
                            <option value=".com.ps">.com.ps</option>
                            <option value=".net.ps">.net.ps</option>
                            <option value=".org.ps">.org.ps</option>
                            <option value=".iq">.iq</option>
                            <option value=".com.iq">.com.iq</option>
                            <option value=".net.iq">.net.iq</option>
                            <option value=".org.iq">.org.iq</option>
                            <option value=".ye">.ye</option>
                            <option value=".com.ye">.com.ye</option>
                            <option value=".net.ye">.net.ye</option>
                            <option value=".org.ye">.org.ye</option>
                            <option value=".ma">.ma</option>
                            <option value=".co.ma">.co.ma</option>
                            <option value=".net.ma">.net.ma</option>
                            <option value=".org.ma">.org.ma</option>
                            <option value=".dz">.dz</option>
                            <option value=".com.dz">.com.dz</option>
                            <option value=".net.dz">.net.dz</option>
                            <option value=".org.dz">.org.dz</option>
                            <option value=".tn">.tn</option>
                            <option value=".com.tn">.com.tn</option>
                            <option value=".net.tn">.net.tn</option>
                            <option value=".org.tn">.org.tn</option>
                            <option value=".ly">.ly</option>
                            <option value=".com.ly">.com.ly</option>
                            <option value=".net.ly">.net.ly</option>
                            <option value=".org.ly">.org.ly</option>
                            <option value=".sd">.sd</option>
                            <option value=".com.sd">.com.sd</option>
                            <option value=".net.sd">.net.sd</option>
                            <option value=".org.sd">.org.sd</option>
                            <option value=".so">.so</option>
                            <option value=".com.so">.com.so</option>
                            <option value=".net.so">.net.so</option>
                            <option value=".org.so">.org.so</option>
                            <option value=".dj">.dj</option>
                            <option value=".com.dj">.com.dj</option>
                            <option value=".net.dj">.net.dj</option>
                            <option value=".org.dj">.org.dj</option>
                            <option value=".mr">.mr</option>
                            <option value=".com.mr">.com.mr</option>
                            <option value=".net.mr">.net.mr</option>
                            <option value=".org.mr">.org.mr</option>
                            <option value=".km">.km</option>
                            <option value=".com.km">.com.km</option>
                            <option value=".net.km">.net.km</option>
                            <option value=".org.km">.org.km</option>
                        </optgroup>
                        <optgroup label="Regular / عادي">
                            <option value=".com" selected="">.com</option>
                            <option value=".net">.net</option>
                            <option value=".org">.org</option>
                            <option value=".info">.info</option>
                            <option value=".biz">.biz</option>
                            <option value=".xyz">.xyz</option>
                            <option value=".online">.online</option>
                            <option value=".site">.site</option>
                            <option value=".store">.store</option>
                            <option value=".shop">.shop</option>
                            <option value=".app">.app</option>
                            <option value=".dev">.dev</option>
                            <option value=".ai">.ai</option>
                            <option value=".io">.io</option>
                            <option value=".me">.me</option>
                            <option value=".co">.co</option>
                            <option value=".cloud">.cloud</option>
                            <option value=".host">.host</option>
                            <option value=".tech">.tech</option>
                            <option value=".agency">.agency</option>
                            <option value=".digital">.digital</option>
                            <option value=".marketing">.marketing</option>
                            <option value=".design">.design</option>
                            <option value=".studio">.studio</option>
                            <option value=".media">.media</option>
                            <option value=".news">.news</option>
                            <option value=".blog">.blog</option>
                            <option value=".live">.live</option>
                            <option value=".world">.world</option>
                            <option value=".global">.global</option>
                            <option value=".company">.company</option>
                            <option value=".services">.services</option>
                            <option value=".solutions">.solutions</option>
                            <option value=".center">.center</option>
                            <option value=".support">.support</option>
                            <option value=".email">.email</option>
                            <option value=".team">.team</option>
                            <option value=".zone">.zone</option>
                            <option value=".space">.space</option>
                            <option value=".today">.today</option>
                            <option value=".life">.life</option>
                            <option value=".club">.club</option>
                            <option value=".pro">.pro</option>
                            <option value=".top">.top</option>
                            <option value=".vip">.vip</option>
                            <option value=".ltd">.ltd</option>
                            <option value=".group">.group</option>
                            <option value=".finance">.finance</option>
                            <option value=".capital">.capital</option>
                            <option value=".money">.money</option>
                            <option value=".insurance">.insurance</option>
                            <option value=".law">.law</option>
                            <option value=".legal">.legal</option>
                            <option value=".consulting">.consulting</option>
                            <option value=".accountant">.accountant</option>
                            <option value=".education">.education</option>
                            <option value=".school">.school</option>
                            <option value=".academy">.academy</option>
                            <option value=".university">.university</option>
                            <option value=".courses">.courses</option>
                            <option value=".training">.training</option>
                            <option value=".events">.events</option>
                            <option value=".tickets">.tickets</option>
                            <option value=".hospital">.hospital</option>
                            <option value=".clinic">.clinic</option>
                            <option value=".care">.care</option>
                            <option value=".health">.health</option>
                            <option value=".fitness">.fitness</option>
                            <option value=".run">.run</option>
                            <option value=".yoga">.yoga</option>
                            <option value=".travel">.travel</option>
                            <option value=".holiday">.holiday</option>
                            <option value=".tours">.tours</option>
                            <option value=".flights">.flights</option>
                            <option value=".hotel">.hotel</option>
                            <option value=".rent">.rent</option>
                            <option value=".cars">.cars</option>
                            <option value=".auto">.auto</option>
                            <option value=".house">.house</option>
                            <option value=".homes">.homes</option>
                            <option value=".property">.property</option>
                            <option value=".realty">.realty</option>
                            <option value=".land">.land</option>
                            <option value=".construction">.construction</option>
                            <option value=".builders">.builders</option>
                            <option value=".engineering">.engineering</option>
                            <option value=".energy">.energy</option>
                            <option value=".solar">.solar</option>
                            <option value=".green">.green</option>
                            <option value=".eco">.eco</option>
                            <option value=".food">.food</option>
                            <option value=".cafe">.cafe</option>
                            <option value=".restaurant">.restaurant</option>
                            <option value=".bar">.bar</option>
                            <option value=".pizza">.pizza</option>
                            <option value=".coffee">.coffee</option>
                            <option value=".wine">.wine</option>
                            <option value=".art">.art</option>
                            <option value=".photo">.photo</option>
                            <option value=".photography">.photography</option>
                            <option value=".video">.video</option>
                            <option value=".film">.film</option>
                            <option value=".music">.music</option>
                            <option value=".band">.band</option>
                            <option value=".radio">.radio</option>
                            <option value=".games">.games</option>
                            <option value=".game">.game</option>
                            <option value=".fun">.fun</option>
                            <option value=".party">.party</option>
                            <option value=".chat">.chat</option>
                            <option value=".social">.social</option>
                            <option value=".link">.link</option>
                            <option value=".press">.press</option>
                            <option value=".work">.work</option>
                            <option value=".jobs">.jobs</option>
                            <option value=".career">.career</option>
                            <option value=".trade">.trade</option>
                            <option value=".exchange">.exchange</option>
                            <option value=".investments">.investments</option>
                            <option value=".crypto">.crypto</option>
                            <option value=".bank">.bank</option>
                            <option value=".security">.security</option>
                            <option value=".network">.network</option>
                            <option value=".systems">.systems</option>
                            <option value=".software">.software</option>
                            <option value=".tools">.tools</option>
                            <option value=".download">.download</option>
                            <option value=".fan">.fan</option>
                            <option value=".fans">.fans</option>
                            <option value=".wiki">.wiki</option>
                            <option value=".page">.page</option>
                            <option value=".website">.website</option>
                            <option value=".web">.web</option>
                            <option value=".mobi">.mobi</option>
                            <option value=".name">.name</option>
                            <option value=".tel">.tel</option>
                            <option value=".int">.int</option>
                            <option value=".ad">.ad</option>
                            <option value=".ae">.ae</option>
                            <option value=".af">.af</option>
                            <option value=".ag">.ag</option>
                            <option value=".al">.al</option>
                            <option value=".am">.am</option>
                            <option value=".ao">.ao</option>
                            <option value=".aq">.aq</option>
                            <option value=".ar">.ar</option>
                            <option value=".as">.as</option>
                            <option value=".at">.at</option>
                            <option value=".au">.au</option>
                            <option value=".aw">.aw</option>
                            <option value=".ax">.ax</option>
                            <option value=".az">.az</option>
                            <option value=".ba">.ba</option>
                            <option value=".bb">.bb</option>
                            <option value=".bd">.bd</option>
                            <option value=".be">.be</option>
                            <option value=".bf">.bf</option>
                            <option value=".bg">.bg</option>
                            <option value=".bh">.bh</option>
                            <option value=".bi">.bi</option>
                            <option value=".bj">.bj</option>
                            <option value=".bl">.bl</option>
                            <option value=".bm">.bm</option>
                            <option value=".bn">.bn</option>
                            <option value=".bo">.bo</option>
                            <option value=".bq">.bq</option>
                            <option value=".br">.br</option>
                            <option value=".bs">.bs</option>
                            <option value=".bt">.bt</option>
                            <option value=".bv">.bv</option>
                            <option value=".bw">.bw</option>
                            <option value=".by">.by</option>
                            <option value=".bz">.bz</option>
                            <option value=".ca">.ca</option>
                            <option value=".cc">.cc</option>
                            <option value=".cd">.cd</option>
                            <option value=".cf">.cf</option>
                            <option value=".cg">.cg</option>
                            <option value=".ch">.ch</option>
                            <option value=".ci">.ci</option>
                            <option value=".ck">.ck</option>
                            <option value=".cl">.cl</option>
                            <option value=".cm">.cm</option>
                            <option value=".cn">.cn</option>
                            <option value=".cr">.cr</option>
                            <option value=".cu">.cu</option>
                            <option value=".cv">.cv</option>
                            <option value=".cw">.cw</option>
                            <option value=".cx">.cx</option>
                            <option value=".cy">.cy</option>
                            <option value=".cz">.cz</option>
                            <option value=".de">.de</option>
                            <option value=".dj">.dj</option>
                            <option value=".dk">.dk</option>
                            <option value=".dm">.dm</option>
                            <option value=".do">.do</option>
                            <option value=".dz">.dz</option>
                            <option value=".ec">.ec</option>
                            <option value=".ee">.ee</option>
                            <option value=".eg">.eg</option>
                            <option value=".eh">.eh</option>
                            <option value=".er">.er</option>
                            <option value=".es">.es</option>
                            <option value=".et">.et</option>
                            <option value=".fi">.fi</option>
                            <option value=".fj">.fj</option>
                            <option value=".fk">.fk</option>
                            <option value=".fm">.fm</option>
                            <option value=".fo">.fo</option>
                            <option value=".fr">.fr</option>
                            <option value=".ga">.ga</option>
                            <option value=".gb">.gb</option>
                            <option value=".gd">.gd</option>
                            <option value=".ge">.ge</option>
                            <option value=".gf">.gf</option>
                            <option value=".gg">.gg</option>
                            <option value=".gh">.gh</option>
                            <option value=".gi">.gi</option>
                            <option value=".gl">.gl</option>
                            <option value=".gm">.gm</option>
                            <option value=".gn">.gn</option>
                            <option value=".gp">.gp</option>
                            <option value=".gq">.gq</option>
                            <option value=".gr">.gr</option>
                            <option value=".gs">.gs</option>
                            <option value=".gt">.gt</option>
                            <option value=".gu">.gu</option>
                            <option value=".gw">.gw</option>
                            <option value=".gy">.gy</option>
                            <option value=".hk">.hk</option>
                            <option value=".hm">.hm</option>
                            <option value=".hn">.hn</option>
                            <option value=".hr">.hr</option>
                            <option value=".ht">.ht</option>
                            <option value=".hu">.hu</option>
                            <option value=".id">.id</option>
                            <option value=".ie">.ie</option>
                            <option value=".il">.il</option>
                            <option value=".im">.im</option>
                            <option value=".in">.in</option>
                            <option value=".iq">.iq</option>
                            <option value=".ir">.ir</option>
                            <option value=".is">.is</option>
                            <option value=".it">.it</option>
                            <option value=".je">.je</option>
                            <option value=".jm">.jm</option>
                            <option value=".jo">.jo</option>
                            <option value=".jp">.jp</option>
                            <option value=".ke">.ke</option>
                            <option value=".kg">.kg</option>
                            <option value=".kh">.kh</option>
                            <option value=".ki">.ki</option>
                            <option value=".km">.km</option>
                            <option value=".kn">.kn</option>
                            <option value=".kp">.kp</option>
                            <option value=".kr">.kr</option>
                            <option value=".kw">.kw</option>
                            <option value=".ky">.ky</option>
                            <option value=".kz">.kz</option>
                            <option value=".la">.la</option>
                            <option value=".lb">.lb</option>
                            <option value=".lc">.lc</option>
                            <option value=".li">.li</option>
                            <option value=".lk">.lk</option>
                            <option value=".lr">.lr</option>
                            <option value=".ls">.ls</option>
                            <option value=".lt">.lt</option>
                            <option value=".lu">.lu</option>
                            <option value=".lv">.lv</option>
                            <option value=".ly">.ly</option>
                            <option value=".ma">.ma</option>
                            <option value=".mc">.mc</option>
                            <option value=".md">.md</option>
                            <option value=".mf">.mf</option>
                            <option value=".mg">.mg</option>
                            <option value=".mh">.mh</option>
                            <option value=".mk">.mk</option>
                            <option value=".ml">.ml</option>
                            <option value=".mm">.mm</option>
                            <option value=".mn">.mn</option>
                            <option value=".mo">.mo</option>
                            <option value=".mp">.mp</option>
                            <option value=".mq">.mq</option>
                            <option value=".mr">.mr</option>
                            <option value=".ms">.ms</option>
                            <option value=".mt">.mt</option>
                            <option value=".mu">.mu</option>
                            <option value=".mv">.mv</option>
                            <option value=".mw">.mw</option>
                            <option value=".mx">.mx</option>
                            <option value=".my">.my</option>
                            <option value=".mz">.mz</option>
                            <option value=".na">.na</option>
                            <option value=".nc">.nc</option>
                            <option value=".ne">.ne</option>
                            <option value=".nf">.nf</option>
                            <option value=".ng">.ng</option>
                            <option value=".ni">.ni</option>
                            <option value=".nl">.nl</option>
                            <option value=".no">.no</option>
                            <option value=".np">.np</option>
                            <option value=".nr">.nr</option>
                            <option value=".nu">.nu</option>
                            <option value=".nz">.nz</option>
                            <option value=".om">.om</option>
                            <option value=".pa">.pa</option>
                            <option value=".pe">.pe</option>
                            <option value=".pf">.pf</option>
                            <option value=".pg">.pg</option>
                            <option value=".ph">.ph</option>
                            <option value=".pk">.pk</option>
                            <option value=".pl">.pl</option>
                            <option value=".pm">.pm</option>
                            <option value=".pn">.pn</option>
                            <option value=".pr">.pr</option>
                            <option value=".ps">.ps</option>
                            <option value=".pt">.pt</option>
                            <option value=".pw">.pw</option>
                            <option value=".py">.py</option>
                            <option value=".qa">.qa</option>
                            <option value=".re">.re</option>
                            <option value=".ro">.ro</option>
                            <option value=".rs">.rs</option>
                            <option value=".ru">.ru</option>
                            <option value=".rw">.rw</option>
                            <option value=".sa">.sa</option>
                            <option value=".sb">.sb</option>
                            <option value=".sc">.sc</option>
                            <option value=".sd">.sd</option>
                            <option value=".se">.se</option>
                            <option value=".sg">.sg</option>
                            <option value=".sh">.sh</option>
                            <option value=".si">.si</option>
                            <option value=".sj">.sj</option>
                            <option value=".sk">.sk</option>
                            <option value=".sl">.sl</option>
                            <option value=".sm">.sm</option>
                            <option value=".sn">.sn</option>
                            <option value=".so">.so</option>
                            <option value=".sr">.sr</option>
                            <option value=".ss">.ss</option>
                            <option value=".st">.st</option>
                            <option value=".sv">.sv</option>
                            <option value=".sx">.sx</option>
                            <option value=".sy">.sy</option>
                            <option value=".sz">.sz</option>
                            <option value=".tc">.tc</option>
                            <option value=".td">.td</option>
                            <option value=".tf">.tf</option>
                            <option value=".tg">.tg</option>
                            <option value=".th">.th</option>
                            <option value=".tj">.tj</option>
                            <option value=".tk">.tk</option>
                            <option value=".tl">.tl</option>
                            <option value=".tm">.tm</option>
                            <option value=".tn">.tn</option>
                            <option value=".to">.to</option>
                            <option value=".tr">.tr</option>
                            <option value=".tt">.tt</option>
                            <option value=".tv">.tv</option>
                            <option value=".tw">.tw</option>
                            <option value=".tz">.tz</option>
                            <option value=".ua">.ua</option>
                            <option value=".ug">.ug</option>
                            <option value=".um">.um</option>
                            <option value=".us">.us</option>
                            <option value=".uy">.uy</option>
                            <option value=".uz">.uz</option>
                            <option value=".va">.va</option>
                            <option value=".vc">.vc</option>
                            <option value=".ve">.ve</option>
                            <option value=".vg">.vg</option>
                            <option value=".vi">.vi</option>
                            <option value=".vn">.vn</option>
                            <option value=".vu">.vu</option>
                            <option value=".wf">.wf</option>
                            <option value=".ws">.ws</option>
                            <option value=".ye">.ye</option>
                            <option value=".yt">.yt</option>
                            <option value=".za">.za</option>
                            <option value=".zm">.zm</option>
                            <option value=".zw">.zw</option>
                            <option value=".uk">.uk</option>
                            <option value=".su">.su</option>
                            <option value=".eu">.eu</option>
                            <option value=".asia">.asia</option>
                            <option value=".cat">.cat</option>
                            <option value=".gov">.gov</option>
                            <option value=".mil">.mil</option>
                        </optgroup>
                    </select>
                </div>

                <div class="flex items-center gap-2 w-full">
                    <input type="text" name="domain-url" placeholder="{{ __('main.domain_search_placeholder') }}" class="w-full font-medium">

                    <button type="submit" class="search-button cursor-pointer">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <p class="mt-6 text-gray-600 text-sm tracking-wide">
                {{ __('main.domain_important_note') }}
            </p>
        </div>
    </form>
    </div>
    {{-- 
<script>
    document.getElementById('domainForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // جمع البيانات
        const domain = document.querySelector('input[name="domain"]:checked')?.value || 'register';
        const domainUrl = document.querySelector('input[name="domain-url"]')?.value || '';
        const extension = document.querySelector('#domain-extension')?.value || '.com';

        if (!domainUrl.trim()) {
            alert('{{ __("main.validation_domain_required") }}');
            return;
        }

        // بناء الـ URL بدون إظهار domain-url
        const url = new URL(this.action);
        url.searchParams.set('a', 'add');
        url.searchParams.set('domain', domain);
        url.searchParams.set('extension', extension);
        // url.searchParams.set('name', domainUrl);

        // فتح الرابط
        window.location.href = url.toString();
    });
</script> --}}
