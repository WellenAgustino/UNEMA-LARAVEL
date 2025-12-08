@props(['items' => []])

<style>
    .breadcrumb-container {
        background: var(--medium-blue);
        border: 1px solid var(--light-blue);
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        /* Setup untuk scroll jika konten terlalu panjang */
        width: 100%;
        box-sizing: border-box;
    }

    .breadcrumb {
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap; /* Default desktop: wrap kalau kepanjangan */
        gap: 0.5rem;
        list-style: none;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        color: var(--text-muted);
        font-size: 0.95rem;
        white-space: nowrap; /* Mencegah teks turun baris di dalam item */
    }

    .breadcrumb-item a {
        color: var(--primary-color-light);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .breadcrumb-item a:hover {
        color: white;
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: white;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .breadcrumb-separator {
        color: var(--light-blue);
        margin: 0 0.25rem;
        font-size: 0.8rem;
    }

    .breadcrumb-icon {
        font-size: 1.1rem;
    }

    /* --- RESPONSIVE MOBILE VIEW --- */
    @media (max-width: 768px) {
        .breadcrumb-container {
            padding: 0.75rem 1rem;
            
            /* Logic Scroll Horizontal */
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch; /* Smooth scroll di iOS */
            
            /* Menyembunyikan Scrollbar agar rapi */
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE 10+ */
        }
        
        /* Sembunyikan scrollbar Chrome/Safari/Opera */
        .breadcrumb-container::-webkit-scrollbar { 
            display: none; 
        }

        .breadcrumb {
            flex-wrap: nowrap; /* PENTING: Jangan turun ke bawah di HP */
            width: max-content; /* Pastikan container mengikuti panjang konten */
        }

        .breadcrumb-item {
            font-size: 0.85rem;
        }

        .breadcrumb-icon {
            font-size: 1rem;
        }
        
        /* Memberikan sedikit padding kanan agar item terakhir tidak mepet layar */
        .breadcrumb::after {
            content: '';
            padding-right: 1rem;
        }
    }
</style>

<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" title="Admin Dashboard">
                    <i class="bi bi-house-fill breadcrumb-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @foreach($items as $index => $item)
                <li class="breadcrumb-separator">
                    <i class="bi bi-chevron-right"></i>
                </li>

                @if($index === count($items) - 1)
                    <li class="breadcrumb-item active" aria-current="page">
                        @if(isset($item['icon']))
                            <i class="bi {{ $item['icon'] }} breadcrumb-icon"></i>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $item['url'] }}" title="{{ $item['label'] }}">
                            @if(isset($item['icon']))
                                <i class="bi {{ $item['icon'] }} breadcrumb-icon"></i>
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>