import { ApplicationConfig, provideBrowserGlobalErrorListeners } from '@angular/core';
import { provideHttpClient } from '@angular/common/http';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
// import { authInterceptor } from './services/auth-interceptor';

export const appConfig: ApplicationConfig = {
  providers: [
    // Remonte les erreurs globales du navigateur à Angular.
    provideBrowserGlobalErrorListeners(),

    // Enregistre toutes les routes définies dans app.routes.ts.
    provideRouter(routes),
    // Authentification temporairement désactivée :
    // provideHttpClient(withInterceptors([authInterceptor])),
    // Rend HttpClient injectable dans les services de l'application.
    provideHttpClient(),
  ]
};
