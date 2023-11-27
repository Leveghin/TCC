#include <TinyGPS++.h>
#include <SoftwareSerial.h>
#include <Ethernet.h>
#include <EthernetClient.h>

#define WIZ_CS  10
#define SDCARD_CS 4

// Defina os pinos RX e TX que você conectou ao seu shield de GPS
#define GPS_RX_PIN 3
#define GPS_TX_PIN 4

SoftwareSerial gpsSerial(GPS_RX_PIN, GPS_TX_PIN); // RX, TX
TinyGPSPlus gps;

EthernetClient client;
byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};  // Endereço MAC fictício
IPAddress server(192,168,1,177); // Substitua pelos números IP do seu servidor

unsigned long previousMillis = 0;
long interval = 60000; // Intervalo para enviar dados

void setup() {
  // Inicia a comunicação serial com Arduino e IDE (Serial Monitor)
  Serial.begin(115200);
  
  // Inicia a comunicação serial entre Arduino e GPS
  gpsSerial.begin(9600);

  Serial.println("Inicializando...");

  // Inicia o módulo Ethernet
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Falha ao configurar Ethernet usando DHCP");
    for(;;);
  }

  delay(500);
}

void loop() {
  unsigned long currentMillis = millis();
  if(currentMillis - previousMillis > interval) {
    previousMillis = currentMillis;
    sendGpsToServer(); // Envia os dados GPS para o servidor
  }

  // Lê os dados do GPS
  while (gpsSerial.available() > 0) {
    if (gps.encode(gpsSerial.read())) {
      if (gps.location.isUpdated()) {
        // Dados de GPS atualizados
        // Aqui você pode processar os dados como necessário
      }
    }
  }
}

int sendGpsToServer() {
  String latitude, longitude;

  // Verifica se temos uma posição válida
  if(gps.location.isValid()) {
    latitude = String(gps.location.lat(), 6);
    longitude = String(gps.location.lng(), 6);

    Serial.print("Latitude= "); 
    Serial.print(latitude);
    Serial.print(" Longitude= "); 
    Serial.println(longitude);

    String url;
    url = "/gpsdata.php?lat=";
    url += latitude;
    url += "&lng=";
    url += longitude;

    Serial.println(url);    
    delay(300);
        
    // Conecta e envia os dados para o servidor
    if (client.connect("ace-oxide.000webhostapp.com", 80)) {
      client.print("GET ");
      client.print(url);
      client.println(" HTTP/1.1");
      client.println("Host:ace-oxide.000webhostapp.com");
      client.println("Connection: close");
      client.println();
      client.stop();  // Fecha a conexão
    } else {
      Serial.println("Conexão falhou");
    }
  } else {
    Serial.println("Localização GPS não é válida");
  }
  return 1;    
}