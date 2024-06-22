<template>
  <div class="absolute left-[50%] top-[50%]" v-if="counter > 0">
    <div>
      <span class="text-[5rem] font-bold">
        {{ counter || 0 }}
      </span>
    </div>
  </div>

  <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
    <InputGroup
      label="Token"
      type="text"
      placeholder="Input token here"
      customClasses="mb-4.5 w-1/2"
      v-model="token"
    />

    <InputGroup
      label="Stake Id"
      type="text"
      placeholder="Stake ID"
      customClasses="mb-4.5"
      v-model="stakeId"
    />

    <PrimaryButton
      @click="onJoinRoom"
      class="flex justify-center w-50 p-3 mx-1 font-medium rounded-3xl bg-[orange] text-gray hover:bg-opacity-90 disabled:bg-opacity-70"
    >
      Join
    </PrimaryButton>
  </div>

  <!-- <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
    <InputGroup
      label="Reservation"
      type="textarea"
      placeholder="Reservation Response"
      customClasses="mb-4.5 w-1/2"
      v-model="reservation"
    />

    <PrimaryButton
      @click="onConsumeReservation"
      class="flex justify-center w-50 p-3 mx-1 font-medium rounded-3xl bg-[orange] text-gray hover:bg-opacity-90 disabled:bg-opacity-70"
    >
      Consume Reservation
    </PrimaryButton>
  </div> -->

  <div class="font-sans text-white bg-gray-800">
    <div class="container p-4 mx-auto">
      <h1 class="mb-4 text-3xl font-bold text-center">Lucky 9 Game Table</h1>

      <div class="grid grid-cols-3 gap-4">
        <!-- Player Cards -->
        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 1</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('1')?.player?.card1,
                      seats.get('1')?.player?.card1?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('1')?.player?.card2,
                      seats.get('1')?.player?.card2?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
              <!-- <div class="w-16 h-24">
                <img src="@/assets/images/deck-cards/card-back.png" alt="Card 1" class="w-full h-full" />
              </div> -->
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">
                BET: {{ seats.get("1")?.bet || 0 }}
              </p>
              <p class="text-sm">
                Chips: {{ seats.get("1")?.player?.chips || 0 }}
              </p>
              <p class="text-sm">
                Declare: {{ seats.get("1")?.player?.declaration || "" }}
              </p>
              <p class="text-sm">
                Card: {{ seats.get("1")?.player?.cardTotal || 0 }}
              </p>
              <p class="text-sm">
                Lucky 9: {{ seats.get("1")?.player?.isLucky9 || 0 }}
              </p>
              <p class="text-sm">
                Banker: {{ seats.get("1")?.player?.is_banker || "" }}
              </p>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 2</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('2')?.card1,
                      seats.get('2')?.card1?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('2')?.card1,
                      seats.get('2')?.card1?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">
                BET: {{ seats.get("2")?.bet || 0 }}
              </p>
              <p class="text-sm">Chips: {{ seats.get("2")?.chips || 0 }}</p>
              <p class="text-sm">
                Declare: {{ seats.get("2")?.declaration || "" }}
              </p>
              <p class="text-sm">Card: {{ seats.get("2")?.cardTotal || 0 }}</p>
              <p class="text-sm">
                Lucky 9: {{ seats.get("2")?.isLucky9 || 0 }}
              </p>
              <p class="text-sm">
                Banker: {{ seats.get("2")?.is_banker || "" }}
              </p>
            </div>
          </div>
        </div>

        <div
          class="relative p-4 bg-gray-700 border-2 rounded-lg border-[#cb3030f9]"
        >
          <h2 class="mb-2 text-xl font-semibold">Seat 3</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('3')?.card1,
                      seats.get('3')?.card1?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
              <div class="w-16 h-24">
                <img
                  :src="
                    getImageUrl(
                      seats.get('3')?.card1,
                      seats.get('3')?.card1?.isRevealedToSelf
                    )
                  "
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">
                BET: {{ seats.get("1")?.bet || 0 }}
              </p>
              <p class="text-sm">Chips: {{ seats.get("1")?.chips || 0 }}</p>
              <p class="text-sm">
                Declare: {{ seats.get("1")?.declaration || "" }}
              </p>
              <p class="text-sm">Card: {{ seats.get("1")?.cardTotal || 0 }}</p>
              <p class="text-sm">
                Lucky 9: {{ seats.get("1")?.isLucky9 || 0 }}
              </p>
              <p class="text-sm">
                Banker: {{ seats.get("1")?.is_banker || "" }}
              </p>

              <p
                class="absolute px-2 text-lg font-bold border rounded-full bottom-1 left-1 bg-red"
              >
                Banker
              </p>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 4</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <img src="card1.png" alt="Card 1" class="w-16 h-24 mr-2" />
              <img src="card2.png" alt="Card 2" class="w-16 h-24" />
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">Total: 5</p>
              <p class="text-sm">Chips: 500</p>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-700 rounded-lg">
          <!--  -->
        </div>

        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 8</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <img src="card1.png" alt="Card 1" class="w-16 h-24 mr-2" />
              <img src="card2.png" alt="Card 2" class="w-16 h-24" />
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">Total: 5</p>
              <p class="text-sm">Chips: 500</p>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 7</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <img src="card1.png" alt="Card 1" class="w-16 h-24 mr-2" />
              <img src="card2.png" alt="Card 2" class="w-16 h-24" />
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">Total: 5</p>
              <p class="text-sm">Chips: 500</p>
            </div>
          </div>
        </div>

        <div class="p-4 bg-gray-700 rounded-lg">
          <!--  -->
        </div>

        <div class="p-4 bg-gray-700 border-2 rounded-lg">
          <h2 class="mb-2 text-xl font-semibold">Seat 5</h2>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <div class="w-16 h-24">
                <img
                  src="@/assets/images/deck-cards/queen_of_hearts2.png"
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
              <div class="w-16 h-24">
                <img
                  src="@/assets/images/deck-cards/card-back.png"
                  alt="Card 1"
                  class="w-full h-full"
                />
              </div>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold">Total: 5</p>
              <p class="text-sm">Chips: 500</p>
            </div>
          </div>
        </div>
      </div>

      <div class="p-4 mt-6 bg-gray-700 border-2 rounded-lg">
        <h2 class="mb-2 text-xl text-center">
          <span class="px-10 py-2 font-bold border bg-red"> Banker </span>
        </h2>
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-2">
            <div class="w-16 h-24">
              <img
                :src="
                  getImageUrl(
                    seats.get('3')?.card1,
                    seats.get('3')?.card1?.isRevealedToSelf
                  )
                "
                alt="Card 1"
                class="w-full h-full"
              />
            </div>
            <div class="w-16 h-24">
              <img
                :src="
                  getImageUrl(
                    seats.get('3')?.card1,
                    seats.get('3')?.card1?.isRevealedToSelf
                  )
                "
                alt="Card 1"
                class="w-full h-full"
              />
            </div>
          </div>
          <div class="text-right">
            <p class="text-lg font-bold">Total: 8</p>
            <p class="text-sm">Chips: 1000</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  colyseusService,
  getAvailableRooms,
} from "@/Services/ColyseusService.js";
import { computed, nextTick, onMounted, reactive, ref, watch } from "vue";
import PrimaryButton from "../PrimaryButton.vue";
import { usePage } from "@inertiajs/vue3";
import InputGroup from "../TailAdmin/Forms/InputGroup.vue";
import axios from "axios";

const page = usePage();
const room = ref(null);
const createdRoom = ref(null);
const messages = ref([]);
const roomState = ref("");
const hasReconnectSession = ref(false);
const players = ref([]);
const potAmount = ref(0);
const events = ref([]);
const hasCard = ref(false);
const showAction = ref(false);
const cards = ref([]);
const counter = ref(0);
const token = ref("");
const roomId = ref("");
const seats = reactive(new Map());
const reservation = ref("");
const stakeId = ref("");

const userUuid = computed(() => {
  return page.props.auth?.user?.uuid || "";
});

const me = computed((playerUuid = "") => {
  return userUuid.value === playerUuid;
});

const playerList = computed(() => {
  const data = createdRoom.value?.state?.players || [];
  console.log("data", data);
  return [];
});

hasReconnectSession.value = localStorage.getItem("reconnection-token")
  ? true
  : false;

const getImageUrl = (imageName, show = false) => {
  let image = imageName;
  if (!show) {
    image = "card-back";
  }
  return new URL(`../../assets/images/deck-cards/${image}.png`, import.meta.url)
    .href;
};

const onJoinRoom = async () => {
  try {
    const { data, status } = await axios.post(
      "http://localhost:2567/api/find-or-create-room",
      {
        token: token.value,
        stakeId: stakeId.value,
      }
    );

    console.log("log-data: ", data);
    console.log("log-status: ", status);

    if ([200, 201, 204].includes(status)) {
      reservation.value = JSON.stringify(data || "{}");
      nextTick(() => {
        onConsumeReservation();
      });
    } else {
      console.error("throw-error: ", data, status);
      throw new Error("Failed to find room: ");
    }
  } catch (error) {
    console.log("error: ", error);
  }
  // createdRoom.value = await colyseusService.joinById(roomId.value, {
  //   token: token.value,
  // });

  // // createdRoom.value?.state.listen("seats", (seatSchema) => {
  // //   console.log("seats", seatSchema);

  // //   seatSchema.forEach(seat => {
  // //     console.log('seat', seat)
  // //   });
  // // });

  // createdRoom.value?.state.seats.onChange((value, key) => {
  //   // console.log(`Changed: ${key} -> ${value}`, value);
  //   console.log("key", key);
  //   console.log("value", value._);
  //   console.log("value", value?.player?.chips);

  //   seats.set(key, value);
  // });
};

const onConsumeReservation = async () => {
  createdRoom.value = await colyseusService.consumeSeatReservation(
    reservation.value
  );

  console.log("createdRoom.value", createdRoom.value);

  createdRoom.value?.state.players.onAdd((player, key) => {
    console.log(player, "has been added at", key);

    // add your player entity to the game world!

    // detecting changes on object properties
    player.listen("decision", (value, previousValue) => {
      console.log(value);
      console.log(previousValue);
    });
  });

  // createdRoom.value?.state.seats.onChange((value, key) => {
  //   console.log(`Changed: ${key} -> ${value}`, value);
  // });
};

const leaveRoom = async () => {
  console.log("leave room");
  createdRoom.value.leave();
  resetTokens();
};

const resetTokens = () => {
  createdRoom.value = null;
  localStorage.removeItem("reconnection-token");
  localStorage.removeItem("ws-room-id");
  localStorage.removeItem("ws-session");
  localStorage.removeItem("ws-id");
  hasReconnectSession.value = false;
};

const reconnectRoom = async () => {
  try {
    let sessionId = localStorage.getItem("ws-session");
    let reconnectionToken = localStorage.getItem("reconnection-token");

    createdRoom.value = await colyseusService.reconnect(reconnectionToken, {
      token: token.value,
    });

    onJoinToRoom(createdRoom.value);
  } catch (error) {
    console.log("error", error);
    resetTokens();
  }
};

const connectRoom = async () => {
  try {
    createdRoom.value = await colyseusService.joinRoom("normal_room", {
      token: token.value,
    });

    onJoinToRoom(createdRoom.value);
  } catch (error) {
    console.log("error", error);
    resetTokens();
  }
};

const onJoinToRoom = async (room) => {
  try {
    console.log("joined successfully", room);

    if (!room) return;

    localStorage.setItem("reconnection-token", room?.reconnectionToken || "");
    localStorage.setItem("ws-room-id", room?.roomId || "");
    localStorage.setItem("ws-session", room?.sessionId || "");
    localStorage.setItem("ws-id", room?.id || "");
    // createdRoom.send("type", "sample")

    // createdRoom.onMessage("message_type", (msg) => {
    //   console.log('sample', msg)
    //   messages.value.push(msg);
    // });

    room.onMessage("waiting", (msg) => {
      console.log("Waiting: ", msg);
      roomState.value = "waiting";

      events.value.push("Waiting Other Player");
    });

    room.onMessage("tableCreated", (msg) => {
      console.log("Table Created: ", msg);
      roomState.value = "start";

      events.value.push("Table Created");
    });

    room.onMessage("playerLeave", (params) => {
      console.log("Player Leave: ", params);
    });

    room.onMessage("youLeave", (params) => {
      console.log("You Leave: ", params);
    });

    room.onMessage("playerReconnected", (params) => {
      console.log("Player Reconnected: ", params);
    });

    room.onMessage("playerPlaceBet", (msg) => {
      console.log("Player place bet: ", msg);
      messages.value.push(msg);
    });

    room.onMessage("playerInTable", (params) => {
      console.log("Player In Table: ", params);
      players.value = params.data?.players || [];
    });

    // ================ Testing ======
    room.onMessage("startRound", (msg) => {
      console.log("startRound ", msg);
      events.value.push("Start Round");
    });

    room.onMessage("collectAllPot", (msg) => {
      console.log("Collect All Pot: ", msg);
      events.value.push("Collect All Pot");
    });

    room.onMessage("submitPot", (msg) => {
      console.log("Submit Pot: ", msg);
      events.value.push("Submit Pot");
    });

    room.onMessage("startBetting", (msg) => {
      console.log("Start Betting", msg);
      events.value.push("Start Betting");
    });

    room.onMessage("collectAllBet", (msg) => {
      console.log("Collect All Bet", msg);
      events.value.push("Collect All Bet");
    });

    room.onMessage("submitBet", (msg) => {
      console.log("Submit Bet", msg);
      events.value.push("Submit Bet");
    });

    room.onMessage("distributeCard", (params) => {
      console.log("Distribute Card", params);
      events.value.push("Distribute Card");

      cards.value = params?.cards || [];

      hasCard.value = true;
    });

    room.onMessage("showBankerCard", (msg) => {
      console.log("Banker Show Card: ", msg);
      events.value.push("Banker Show Card: " + msg);
    });

    room.onMessage("showCard", (params) => {
      console.log("Show Card: ", params);
      events.value.push("Card: " + params?.cards?.toString());

      showAction.value = true;
      // cards.value = params?.cards || [];
    });

    room.onMessage("waitingBankerAction", (msg) => {
      console.log("Waiting Banker Action: ", msg);
      events.value.push("Waiting Banker Action: " + msg);
    });

    room.onMessage("declaration", (msg) => {
      console.log("Winner/Lose Declaration: ", msg);
      events.value.push("Winner/Lose Declaration: " + msg);
    });

    room.onMessage("distributeWinLosePrice", (msg) => {
      console.log("Distribute Prices: ", msg);
      events.value.push("Distribute Prices: " + msg);
    });

    room.onMessage("showRoundResults", (msg) => {
      console.log("Show Round Results: ", msg);
      events.value.push("Show Round Results: " + msg);
    });

    // ============ END =========

    room.onMessage("betExists", (msg) => {
      console.log("Already: ", msg);
    });

    room.state.listen("potAmount", (amount) => {
      potAmount.value = amount || 0;
    });

    room.state.listen("countdown", (value) => {
      console.log("counter", value);
      counter.value = value;
      // events.value.push("Count Down: " + counter);
    });

    room.state.listen("gameStatus", (value) => {
      console.log("gameStatus", value);
    });

    room.state.listen("interval", (value) => {
      console.log("interval", value);
    });

    // listen players schema
    room.state.players.onAdd((player, key) => {
      console.log(player, "has been added at", key);
    });

    room.state.players.onRemove((player, key) => {
      console.log(player, "has been remove at", key);

      players.value = players.value.filter(
        (i) => i.sessionId !== player.sessionId
      );
    });

    // room.onMessage("new_player_join", (msg) => {
    //   console.log("New Player Join: ", msg);
    //   roomState.value = "start";
    // });

    // room.onMessage("you_join", (msg) => {
    //   console.log("You Join: ", msg);
    //   roomState.value = "start";
    // });

    // room.onMessage("winner", (params) => {
    //   console.log("Winner: ", params?.player?.uuid);

    //   const winnerUuid = params?.player?.uuid;
    //   if (winnerUuid === userUuid) {
    //     console.log("You win");
    //   } else {
    //     console.log("You loss");
    //   }
    // });

    // createdRoom.value.onStateChange((state) => {
    //   console.log("State has changed:", state);
    // });

    room.onLeave((code) => {
      console.log("Left the room with code:", code);
      roomState.value = "";
    });

    availableRooms();
  } catch (error) {
    console.log("error", error);
    localStorage.removeItem("reconnection-token");
    localStorage.removeItem("ws-room-id");
    localStorage.removeItem("ws-session");
    localStorage.removeItem("ws-id");
  }
};

const onPlaceBet = (amount = 0) => {
  createdRoom.value.send("onPlayerStartBetting", { amount: amount });
};

const availableRooms = async () => {
  const rooms = await getAvailableRooms();

  console.log("rooms", rooms);
};

const showCard = () => {
  createdRoom.value.send("onPlayerRequestShowCard");

  hasCard.value = false;
};

const actionHirit = () => {
  // createdRoom.value.send("onBankerAction", { action: "HIRIT" })
  createdRoom.value.send("hirit");
  // showAction.value = false;
};

const actionGood = () => {
  // createdRoom.value.send("onBankerAction", { action: "GOODS" })
  createdRoom.value.send("goods");
  // showAction.value = false;
};

onMounted(() => {
  // room.value?.onMessage("type", (msg) => {
  //   messages.value.push(msg);
  // });

  availableRooms();
});
</script>

<style scoped>
/* Add your styles here */
</style>
