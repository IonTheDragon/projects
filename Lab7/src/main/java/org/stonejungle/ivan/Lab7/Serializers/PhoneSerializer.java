package org.stonejungle.ivan.Lab7.Serializers;

import com.fasterxml.jackson.core.JsonGenerator;
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.SerializerProvider;
import com.fasterxml.jackson.databind.ser.std.StdSerializer;
import org.stonejungle.ivan.Lab7.Devices.Phone;
import java.util.UUID;

import java.io.IOException;

public class PhoneSerializer extends StdSerializer<Phone> {

        public PhoneSerializer() {
            this(null);
        }

        public PhoneSerializer(Class<Phone> t) {
            super(t);
        }

        @Override
        public void serialize(
                Phone value, JsonGenerator jgen, SerializerProvider provider)
                throws IOException, JsonProcessingException {

            jgen.writeStartObject();
            jgen.writeStringField("id", value.id.toString());
            jgen.writeStringField("device type", value.deviceType);
            jgen.writeStringField("name", value.name);
            jgen.writeStringField("price", value.price);
            jgen.writeStringField("count", value.count);
            jgen.writeStringField("company", value.company);
            jgen.writeStringField("model", value.model);
            jgen.writeStringField("os", value.os);
            jgen.writeStringField("type", value.type);
            jgen.writeStringField("param2", value.param2);
            jgen.writeEndObject();

        }
}
