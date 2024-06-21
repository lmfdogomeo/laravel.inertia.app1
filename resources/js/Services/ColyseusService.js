import { usePage } from '@inertiajs/vue3';
import { Client } from 'colyseus.js';

const page = usePage();

const client = new Client('ws://localhost:2567'); // Adjust the server URL as needed

export const colyseusService = {
  client,
  async joinRoom(roomName, params) {
    const room = await client.joinOrCreate(roomName, {
      token: params?.token || "",
      user: {
        uuid: page.props.auth?.user?.uuid || "",
        name: page.props.auth?.user?.name || "",
        email: page.props.auth?.user?.email || "",
      }
    });
    // const room = await client.join(roomName);
    return room;
  },
  async joinById(roomId, params) {
    client.auth.token = params?.token || "";
    const room = await client.joinById(roomId);
    // const room = await client.join(roomName);
    return room;
  },

  async reconnect(token) {
    const room = await client.reconnect(token);
    // const room = await client.join(roomName);
    return room;
  },
};

export const getAvailableRooms = async() => {
  const rooms = await client.getAvailableRooms();
  return rooms;
}
