// src/app/app.config.ts
import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';
import { provideHttpClient, withInterceptors } from '@angular/common/http';

import { routes } from './app.routes';
import { authInterceptor } from './core/interceptors/auth.interceptor';

// (Opcional) Si usas SSR o Angular Universal
// import { provideClientHydration } from '@angular/platform-browser';
// (Opcional) Si usas animaciones Angular
// import { provideAnimations } from '@angular/platform-browser/animations';

export const appConfig: ApplicationConfig = {
  providers: [
    provideRouter(routes),

    // Configura el cliente HTTP con interceptores personalizados
    provideHttpClient(
      withInterceptors([
        authInterceptor // << intercepta las peticiones para agregar el token Bearer
      ])
    ),

    // (Descomenta si los usas)
    // provideClientHydration(),
    // provideAnimations(),
  ]
};
