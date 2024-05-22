<div class="layanan-sky">
    <h2 class="text-center mb-4 fw-bold">Service Kunjung Yamaha</h2>
    <div class="mb-4 layanan-header">
        <div class="layanan-side-left">
            <img src="{{ url('/images/Artboard2.png') }}" alt="sky-icon">
        </div>
        <div class="layanan-side-right">
            <p>Yamaha Tjahaja Baru kini menyediakan Service Kunjung Yamaha (SKY), yaitu Service yang dapat diminta untuk melakukan kunjungan service di rumah, kantor maupun kondisi darurat, tanpa perlu datang ke dealer.</p>
        </div>
    </div>

    <div class="row layanan-konten">
        <div class="col-md-6">
            <h5>Isi form di bawah ini sesuai instruksi dan team kami akan segera merespon Anda.</h5>
            <form method="POST" action="{{ route('service.kunjung.yamaha') }}" id="form-sky">
                @csrf
                <div class="form-group">
                    <label for="sky-name" class="col-form-label text-md-right">Nama :</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror roboto-regular" name="sky_name" id="sky-name" value="{{ $user->name ?? '' }}" placeholder="Nama" required>
                    <span class="text-danger" id="error-sky-name" style="display:none;">Nama tidak boleh kosong.</span>
                </div>
    
                <div class="form-group">
                    <label for="sky-alamat" class="col-form-label text-md-right">Alamat :</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror roboto-regular" name="sky_alamat" id="sky-alamat" value="Damar" required>
                    <span class="text-danger" id="error-sky-alamat" style="display:none;">Alamat tidak boleh kosong.</span>
                </div>
                
                <div class="form-group">
                    <label for="sky-phone-number" class="col-form-label text-md-right">No Handphone / Whatsapp :</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror roboto-regular" name="sky_phone_number" id="sky-phone-number" value="{{ $user->phone_number ?? '' }}" placeholder="081234567xxx" required>
                    <span class="text-danger" id="error-sky-phone-number" style="display:none;">No Handphone tidak boleh kosong.</span>
                </div>
    
                <div class="form-group">
                    <label for="sky-tipe" class="col-form-label text-md-right">Tipe Motor :</label>
                    <input type="text" class="form-control @error('tipe') is-invalid @enderror roboto-regular" name="sky_tipe" id="sky-tipe" value="NMAX" placeholder="081234567xxx" required>
                    <span class="text-danger" id="error-sky-tipe" style="display:none;">Tipe tidak boleh kosong.</span>
                </div>
    
                <div class="form-group">
                    <label for="sky-kendala" class="col-form-label text-md-right">Kendala :</label>
                    <input type="text" class="form-control @error('kendala') is-invalid @enderror roboto-regular" name="sky_kendala" id="sky-kendala" value="ganti oli" required>
                    <span class="text-danger" id="error-sky-kendala" style="display:none;">Kendala tidak boleh kosong.</span>
                </div>
                
                <div class="form-group">
                    {!! RecaptchaV3::field('send_sky') !!}
                    @error('g-recaptcha-response')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <h5>Keterangan Service Kunjung Yamaha :</h5>
            <ul>
                <li>Isi terlebih dahulu Form Service Kunjung Yamaha ini, tunggu hingga Call Center SKY menghubungi Anda untuk konfirmasi data dan waktu service.</li>
                <li>Minimal 1 hari sebelumnya Service Motor.</li>
                <li>Diperuntukkan untuk Perorangan, Perusahaan Swasta / Instansi Pemerintahan, dan  Komunitas Motor Yamaha.</li>
                <li>Pastikan Form Service Kunjung Yamaha terisi dengan benar, apabila tidak terisi dengan benar, mohon maaf data Anda belum bisa diproses.</li>
            </ul>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Call Center 1</h5>
                        <a href="#" class="btn btn-primary">Call</a>
                      </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Call Center 2</h5>
                        <a href="#" class="btn btn-primary">Call</a>
                      </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Call Center 3</h5>
                        <a href="#" class="btn btn-primary">Call</a>
                      </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Call Center 4</h5>
                        <a href="#" class="btn btn-primary">Call</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>