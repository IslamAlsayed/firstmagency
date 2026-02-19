<div class="section programming-section text-center">
    <div class="title font-semibold">برمجة <span class="title-badge">المواقع الاحترافية</span></div>
    <div class="description">نقوم ببرمجة وتطوير المواقع الإلكترونية على أعلى مستوى — تصميم عصري، سرعة ممتازة، وتجربة مستخدم ترفع ثقة العميل في علامتك
        التجارية.</div>

    <div class="websites-items grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach (config('websites') as $website)
            <a href="#" class="website">
                <div class="image">
                    <img src="{{ asset('assets/images/' . $website['image']) }}" alt="{{ $website['title'] }}">
                </div>
                <div class="title font-semibold">{{ $website['title'] }}</div>
            </a>
        @endforeach
    </div>
</div>
