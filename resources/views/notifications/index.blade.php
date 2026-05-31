@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Pusat Notifikasi')

@section('breadcrumb')
  <li class="breadcrumb-item active">Notifikasi</li>
@endsection

@section('page-actions')
  <form action="{{ route('notifications.read') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-primary btn-sm">Tandai Semua Dibaca</button>
  </form>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="pandu-card">
      <div class="list-group list-group-flush">
        @forelse($notifications as $notif)
          <div class="list-group-item p-4 {{ $notif->unread() ? 'bg-info-soft' : '' }}">
            <div class="d-flex gap-4">
              <div class="icon-box-lg {{ $notif->unread() ? 'bg-primary text-white' : 'bg-light text-secondary' }} rounded-circle">
                <i class="fas {{ str_contains($notif->data['title'], 'DARURAT') ? 'fa-exclamation-triangle' : 'fa-bell' }}"></i>
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start mb-1">
                  <h5 class="fw-bold mb-0 {{ $notif->unread() ? 'text-dark' : 'text-secondary' }}">{{ $notif->data['title'] }}</h5>
                  <span class="smaller text-muted">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
                <p class="mb-3 {{ $notif->unread() ? 'text-dark' : 'text-secondary' }}">{{ $notif->data['message'] }}</p>
                @if($notif->data['url'] !== '#')
                  <a href="{{ $notif->data['url'] }}" class="btn btn-sm btn-pandu-primary">Lihat Detail</a>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="p-5 text-center text-secondary">
             <i class="fas fa-bell-slash fa-3x mb-3 opacity-25"></i>
             <p>Tidak ada notifikasi untuk Anda.</p>
          </div>
        @endforelse
      </div>
    </div>
    <div class="mt-4">
       {{ $notifications->links() }}
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bg-info-soft { background-color: rgba(21, 101, 192, 0.03); }
  .smaller { font-size: 0.75rem; }
</style>
@endpush
